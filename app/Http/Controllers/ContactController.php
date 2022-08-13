<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function destroy(User $contact)
    {
        $user1 = User::find($contact->id)->contact->where('user2_id', Auth::user()->id)->first();
        $user1->delete();

        $user2 = Auth::user()->contact->where('user2_id', $contact->id)->first();
        $user2->delete();

        return redirect()->route('dashboard');
    }
}
