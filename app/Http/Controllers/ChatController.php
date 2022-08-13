<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Chat;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(User $contact)
    {
        $user = Auth::user()->contact()->where('user2_id', $contact->id)->first();
        $contact = $contact->contact()->where('user2_id', Auth::user()->id)->first();
        $chat='';
        $chat2='';
        if(!$user->chat && !$contact->chat){
            $chat = $user->chat()->create([
                "contact_id" => $user->id
            ]);
            $chat2 = $contact->chat()->create([
                "contact_id" => $contact->id
            ]);
        }
        if(!$chat){
            $chat = $user->chat;
        }
        if(!$chat2){
            $chat2 = $contact->chat;
        }
        $contact = $contact->user;
        //return $chat2;
        return view('chat', compact('chat', 'chat2', 'contact'));

    }

    public function store(Request $req)
    {
        $req->validate([
            "message" => "required"
        ]);

        $user_id = Contact::where('user_id', Auth::user()->id)->where('user2_id', $req->contact)->first();
        $contact_id = Contact::where('user_id', $req->contact)->where('user2_id', Auth::user()->id)->first();

        Message::create([
            'chat_id' => $user_id->chat->id,
            'user_id' => Auth::user()->id,
            'mensaje' => $req->input('message'),
            'deleted_message' => '0'
        ]);

        Message::create([
            'chat_id' => $contact_id->chat->id,
            'user_id' => Auth::user()->id,
            'mensaje' => $req->input('message'),
            'deleted_message' => '0'
        ]);

        return redirect()->route('chat.index', ['contact' => $contact_id->user_id]);
    }

    public function destroyAllChatMessages(Request $req){
        $chat_id = $req->chat_id;
        $contact_id = $req->contact_id; 
        $message = new Message;
        
        if($message->where('chat_id', $chat_id)->where('user_id', Auth::user()->id)->get()){
            $message->where('chat_id', $chat_id)->where('user_id', Auth::user()->id)->delete();
        }

        if($message->where('chat_id', $chat_id)->where('user_id', $contact_id)->get()){
            $message->where('chat_id', $chat_id)->where('user_id', $contact_id)->delete();
        }
 
        return redirect()->route('chat.index', ['contact' => $contact_id]);

    }

    public function destroyMessageMyChat($message_id, $chat_id, User $contact){
        Message::where('id', $message_id)->first()->delete();
        return redirect()->route('chat.index', ['contact' => $contact]);
    }

    public function destroyMessageBothChat($message_id, $chat_id, $chat2_id, User $contact){
        //return [$message_id, $chat_id, $chat2_id, $contact, array()];
        if(Message::where('id', $message_id)->where('chat_id', $chat_id)->first() && Message::where('id', $message_id+1)->where('chat_id', $chat2_id)->first()){
            Message::where('id', $message_id)->where('chat_id', $chat_id)->first()->delete();
            Message::where('id', $message_id+1)->where('chat_id', $chat2_id)->first()->delete();
        } 
        return redirect()->route('chat.index', ['contact' => $contact]);
    }


}
