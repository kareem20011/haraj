<?php

namespace App\Http\Controllers\web;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // جلب كل المستخدمين الذين تم التحدث معهم مسبقًا
        $users = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender', 'receiver']) // جلب بيانات المرسل والمستلم
            ->get()
            ->map(function ($message) use ($userId) {
                return $message->sender_id == $userId ? $message->receiver : $message->sender;
            })
            ->unique('id') // إزالة التكرارات
            ->values(); // إعادة تعيين المفاتيح

        // تمرير المستخدمين والرسائل إلى نفس `view`
        return view('web.chat.index', compact('users'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string'
        ]);

        $message = Message::create([
            'sender_id' => auth()->user()->id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message, 201);
    }

    public function getMessages($receiverID)
    {
        $receiver = User::find($receiverID);
        $userId = auth()->id();

        // جلب كل الرسائل بين المستخدم الحالي والمستلم
        $messages = Message::where(function ($query) use ($receiverID, $userId) {
            $query->where('sender_id', $userId)->where('receiver_id', $receiverID);
        })->orWhere(function ($query) use ($receiverID, $userId) {
            $query->where('sender_id', $receiverID)->where('receiver_id', $userId);
        })->orderBy('created_at', 'asc')->get();

        // جلب كل المستخدمين الذين تم التحدث معهم مسبقًا
        $users = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender', 'receiver']) // جلب بيانات المرسل والمستلم
            ->get()
            ->map(function ($message) use ($userId) {
                return $message->sender_id == $userId ? $message->receiver : $message->sender;
            })
            ->unique('id') // إزالة التكرارات
            ->values(); // إعادة تعيين المفاتيح

        // تمرير المستخدمين والرسائل إلى نفس `view`
        return view('web.chat.index', compact('users', 'messages', 'receiver'));
    }
}
