<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Conversation;
use App\Models\Message;

class ChatbotController extends Controller
{
    public function index()
    {
        $conversationId = session('conversation_id');
        $history = session('chat_history', []);

        return view('chatbot.index', [
            'history' => $history,
            'conversations' => Conversation::where('user_id', Auth::id())->latest()->get(),
            'currentConversationId' => $conversationId,
        ]);
    }

    public function chat(Request $request)
    {
        $question = $request->input('question');

        $response = Http::timeout(30)->post('http://127.0.0.1:8001/api/v1/chat', [
            'question' => $question,
        ]);

        $answer = $response->json()['answer'] ?? 'Không có phản hồi từ chatbot.';

        $conversationId = session('conversation_id');

        if (!$conversationId) {
            $conversation = Conversation::create([
                'title' => Str::limit($question, 50),
                'user_id' => Auth::id(),
            ]);
            session(['conversation_id' => $conversation->id]);
        } else {
            $conversation = Conversation::where('id', $conversationId)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // 🔧 Cập nhật tiêu đề nếu còn là mặc định hoặc chưa đặt
            if (!$conversation->title || $conversation->title === 'Cuộc trò chuyện mới') {
                $conversation->update([
                    'title' => Str::limit($question, 50),
                ]);
            }
        }

        $conversation->messages()->create([
            'question' => $question,
            'answer' => $answer,
        ]);

        $history = $conversation->messages()->get(['question', 'answer'])->toArray();
        session(['chat_history' => $history]);

        return redirect('/chat');
    }

    public function newConversation()
    {
        session()->forget(['conversation_id', 'chat_history']);

        $conversation = Conversation::create([
            'title' => 'Cuộc trò chuyện mới',
            'user_id' => Auth::id(),
        ]);

        session(['conversation_id' => $conversation->id]);

        return redirect('/chat');
    }

    public function clear()
    {
        session()->forget(['conversation_id', 'chat_history']);
        return redirect('/chat');
    }
}
