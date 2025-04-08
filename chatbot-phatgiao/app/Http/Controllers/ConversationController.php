<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    // Danh sách tất cả các cuộc trò chuyện
    public function index()
    {
        $conversations = Conversation::latest()->get();
        return view('chatbot.sidebar', compact('conversations'));
    }

    // Xem một cuộc trò chuyện cụ thể
    public function show($id)
    {
        $conversation = Conversation::with('messages')->findOrFail($id);

        session([
            'conversation_id' => $conversation->id,
            'chat_history' => $conversation->messages()->get(['question', 'answer'])->toArray(),
        ]);

        return redirect('/chat');
    }

    // Xóa một cuộc trò chuyện
    public function destroy($id)
    {
        $conversation = Conversation::findOrFail($id);
        $conversation->delete();

        // Nếu là cuộc trò chuyện hiện tại, xóa khỏi session
        if (session('conversation_id') == $id) {
            session()->forget(['conversation_id', 'chat_history']);
        }

        return back()->with('success', 'Đã xóa cuộc trò chuyện.');
    }
}

