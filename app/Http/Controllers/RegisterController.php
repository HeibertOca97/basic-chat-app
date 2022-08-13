<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('signup');
    }

    public function store(Request $req)
    {
        $response = $req->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users', 'max:200'],
            'password' => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ]);

        User::create(array(
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
        ));

        return back()->with('success', "Su registro ha sido exitoso");
    }
}
