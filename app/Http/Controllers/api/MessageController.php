<?php

namespace App\Http\Controllers\api;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
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

    public function getMessages($userId)
    {
        $messages = Message::where(function ($query) use ($userId) {
            $query->where('sender_id', auth()->user()->id)->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($userId) {
            $query->where('sender_id', $userId)->where('receiver_id', auth()->user()->id);
        })->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }

    public function oldChats()
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

        return response()->json($users);
    }
}
