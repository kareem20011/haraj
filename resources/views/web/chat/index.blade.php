@extends('layouts.layout')
@section('web.title')
{{ __('titles.brand') }} - {{ __('titles.chat') }}
@endsection
@section('content')
<div class="container mt-2">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card chat-app">

                <!-- side bar -->
                <div id="plist" class="people-list">
                    <!-- users list -->
                    <ul class="list-unstyled chat-list mt-2 mb-0">
                        @foreach($users as $user)
                        <li class="clearfix {{ isset($receiver) && $user->id == $receiver->id ? 'active' : '' }}">
                            @if($user->getFirstMediaUrl())
                            <img loading="lazy" src="{{ $user->getFirstMediaUrl() }}" alt="User Avatar">
                            @else
                            <img loading="lazy" src="{{ asset('assets/images/avatar.png') }}" alt="User Avatar">
                            @endif
                            <div class="about">
                                <a href="{{ route( 'chat.getMessages', $user->id ) }}" class="name">{{$user->name}}</ش>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Chat box -->
                <div class="chat">
                    <!-- Chat header -->
                    <div class="chat-header clearfix">
                        <div class="row d-flex align-items-center justify-content-between">
                            <div class="col-6 d-flex align-items-center">
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                    @if(isset($receiver) && $receiver->getFirstMediaUrl())
                                    <img loading="lazy" src="{{ $receiver->getFirstMediaUrl() }}" alt="User Avatar" class="rounded-circle" width="40">
                                    @else
                                    <img loading="lazy" src="{{ asset('assets/images/avatar.png') }}" alt="User Avatar" class="rounded-circle" width="40">
                                    @endif
                                </a>
                                <div class="chat-about ml-2">
                                    <h6 class="m-b-0">{{ isset($messages) ? $receiver->name : 'select user' }}</h6>
                                </div>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                <a href="{{ route( 'home' ) }}" class="btn btn-outline-secondary btn-sm me-2"><i class="fa fa-home"></i></a>
                                <button id="side_toggle" class="btn btn-outline-secondary btn-sm me-2"><i class="fa fa-bars"></i></button>
                            </div>
                        </div>
                    </div>

                    
                    <!-- Chat history -->
                    <div class="chat-history">
                        @if(isset($messages))
                        <ul class="m-b-0">
                            @foreach($messages as $message)
                            @if($message->sender_id == auth()->user()->id)
                            <li class="clearfix">
                                <div class="message-data text-right">
                                    <span class="message-data-time">{{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}</span>
                                </div>
                                <div class="message other-message float-right"> {{ $message->message }} </div>
                            </li>
                            @else
                            <li class="clearfix">
                                <div class="message-data">
                                    <span class="message-data-time">{{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}</span>
                                </div>
                                <div class="message my-message"> {{ $message->message }} </div>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                        @endif
                    </div>

                    @if(isset($messages))
                    <!-- Send new message -->
                    <div class="chat-message clearfix">
                        <div class="input-group mb-0">
                            <div id="sendMessage" class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-send"></i></span>
                            </div>
                            <input type="text" id="messageInput" class="form-control" placeholder="Enter text here...">
                        </div>
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    const side_toggle = document.getElementById('side_toggle')
    const side_bar = document.getElementById('plist')

    side_toggle.onclick = function() {
        //side_bar.style.display = "block";
        if (side_bar.style.display == "block") {
            side_bar.style.display = "none"
        } else {
            side_bar.style.display = "block"
        }
    }

    $(document).ready(function() {
        scrollToBottom()

        $("#sendMessage").click(function() {
            let message = $("#messageInput").val(); // جلب نص الرسالة
            let receiverId = "{{ $receiver->id ?? '' }}"; // جلب ID المستقبل


            if (message.trim() === "") {
                alert("لا يمكن إرسال رسالة فارغة!");
                return;
            }

            $.ajax({
                url: "{{ route('chat.sendMessage') }}", // مسار إرسال الرسالة
                type: "POST",
                data: {
                    message: message,
                    receiver_id: receiverId,
                    _token: "{{ csrf_token() }}" // حماية ضد هجمات CSRF
                },
                success: function(response) {
                    console.log("تم إرسال الرسالة بنجاح:", response);

                    // إضافة الرسالة إلى واجهة المستخدم مباشرةً
                    $(".chat-history ul").append(`
                            <li class="clearfix">
                                <div class="message-data text-right">
                                    <span class="message-data-time">${moment().fromNow()}</span>
                                </div>
                                <div class="message other-message float-right">${message}</div>
                            </li>
                        `);

                    $("#messageInput").val(""); // مسح الحقل بعد الإرسال
                    scrollToBottom()
                },
                error: function(xhr) {
                    console.error("خطأ في إرسال الرسالة:", xhr.responseText);
                    alert("حدث خطأ أثناء إرسال الرسالة، حاول مرة أخرى.");
                }
            });
        });
    });

    const userID = "{{ auth()->user()->id }}";

    // تهيئة Pusher
    const pusher = new Pusher("ebcfbf3dce3bf3b89db3", {
        cluster: "eu",
        encrypted: true,
        authEndpoint: "/broadcasting/auth", // نقطة التوثيق
    });

    // الاشتراك في القناة الخاصة بالمستخدم
    const channel = pusher.subscribe(`private-chat.${userID}`);

    // الاستماع لاستقبال الرسائل الجديدة
    channel.bind("MessageSent", function(data) {
        let currentReceiverId = "{{ $receiver->id ?? '' }}"; // ID المستخدم الحالي في الشات
        let messageSenderId = data.message.sender_id; // ID المرسل للرسالة

        // ✅ التحقق أن الرسالة تخص المحادثة الحالية فقط
        if (messageSenderId == currentReceiverId) {
            displayMessage(data.message, data.message.sender_id == userID ? "sent" : "received");
        }
        // displayMessage(data.message, data.message.sender_id == userID ? "sent" : "received");
    });

    let chatHistory = document.querySelector(".chat-history");
    // ✅ Function لإضافة الرسالة في الشات
    function displayMessage(message, type) {
        // إنشاء عنصر جديد للرسالة
        const li = document.createElement("li");
        li.classList.add("clearfix");

        if (type === "sent") {
            li.innerHTML = `
                <div class="message-data text-right">
                    <span class="message-data-time">${moment(message.created_at).fromNow()}</span>
                </div>
                <div class="message other-message float-right">${message.message}</div>
            `;
        } else {
            li.innerHTML = `
                <div class="message-data">
                    <span class="message-data-time">${moment(message.created_at).fromNow()}</span>
                </div>
                <div class="message my-message">${message.message}</div>
            `;
        }

        // إضافة الرسالة إلى الشات
        chatHistory.appendChild(li);

        // تحريك الشات للأسفل تلقائيًا
        scrollToBottom()
    }

    function scrollToBottom() {
        chatHistory.scrollTop = chatHistory.scrollHeight;
    }
</script>

@endsection
@endsection