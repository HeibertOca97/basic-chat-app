<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Chat;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ChatController extends Controller
{
    public function index(User $contact)
    {
        $chat = [];
        $chat2 = [];
        if(Cache::has('contact_id') && Cache::get('contact_id') == $contact->id){
            if(Cache::has("chat_user_id") || Cache::has('chat_user2_id') || Cache::has('contact_id_')){
                $key1 = 'chat' . Cache::get("chat_user_id");
                $key2 = 'chat2' . Cache::get("chat_user2_id");
                $key3 = 'contact' . Cache::get('contact_id');
            }
            if(Cache::has($key1) && Cache::has($key2) && Cache::has($key3)){
                $chat = Cache::get($key1);
                $chat2 = Cache::get($key2);
                $contact = Cache::get($key3);
            }

        }else{
            $checkingMyListContact = Auth::user()->contact()->where('user2_id', $contact->id)->first();
            if($checkingMyListContact){
                $checkingHisListContact = $contact->contact()->where('user2_id', Auth::user()->id)->first();
            }

            if(!$checkingMyListContact->chat && !$checkingHisListContact->chat){
                $chat = $checkingMyListContact->chat()->create([
                    "contact_id" => $checkingMyListContact->id
                ]);
                $chat2 = $checkingHisListContact->chat()->create([
                    "contact_id" => $checkingHisListContact->id
                ]);
            }
            if($checkingMyListContact->chat){
                $chat = $checkingMyListContact->chat; 
                Cache::put('chat'.$checkingMyListContact->id, $checkingMyListContact->chat);
                Cache::put('chat_user_id', $checkingMyListContact->id);
            }

            if($checkingHisListContact->chat){
                $chat2 = $checkingHisListContact->chat;
                Cache::put('chat2'.$checkingHisListContact->id, $checkingHisListContact->chat);
                Cache::put('chat_user2_id', $checkingHisListContact->id);
            }

            $contact = $checkingHisListContact->user;
            Cache::put('contact'.$contact->id, $contact);
            Cache::put('contact_id', $contact->id);
        }

        return view('chat', compact('chat', 'chat2', 'contact'));
    }

    public function store(Request $req)
    {
        $req->validate([
            "message" => "required"
        ]);

        $myListContact = Auth::user()->contact()->where('user2_id', $req->contact)->first();
        if($myListContact){
            $hisListContact = Contact::where('user_id', $req->contact)->where('user2_id', Auth::user()->id)->first();
        }

        Message::create([
            'chat_id' => $myListContact->chat->id,
            'user_id' => Auth::user()->id,
            'mensaje' => $req->input('message'),
            'deleted_message' => '0'
        ]);

        Message::create([
            'chat_id' => $hisListContact->chat->id,
            'user_id' => Auth::user()->id,
            'mensaje' => $req->input('message'),
            'deleted_message' => '0'
        ]);

        Cache::put('chat'.$myListContact->id, $myListContact->chat);
        Cache::put('chat_user_id', $myListContact->id);
        Cache::put('chat2'.$hisListContact->id, $hisListContact->chat);
        Cache::put('chat_user2_id', $hisListContact->id);
        $contact = $hisListContact->user;
        Cache::put('contact'.$contact->id, $contact);
        Cache::put('contact_id', $contact->id);

        return redirect()->route('chat.index', ['contact' => $hisListContact->user_id]);
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
        if(Message::where('id', $message_id)->where('chat_id', $chat_id)->first() && Message::where('id', $message_id+1)->where('chat_id', $chat2_id)->first()){
            Message::where('id', $message_id)->where('chat_id', $chat_id)->first()->delete();
            Message::where('id', $message_id+1)->where('chat_id', $chat2_id)->first()->delete();
        } 
        return redirect()->route('chat.index', ['contact' => $contact]);
    }


}
