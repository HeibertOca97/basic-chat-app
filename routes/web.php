<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $users = App\Models\User::all();
    return view('welcome', compact('users'));
});

Route::get('/signin', [App\Http\Controllers\LoginController::class, 'index'])->name('signin')->middleware('guest');

Route::post('/signin/auth', [App\Http\Controllers\LoginController::class, 'authenticate'])->name('signin.auth');

Route::get('/signup', [App\Http\Controllers\RegisterController::class, 'index'])->name('signup');

Route::post('/signup/store', [App\Http\Controllers\RegisterController::class, 'store'])->name('signup.store');


Route::middleware(['auth'])->group(function () {
Route::delete('/auth/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::delete('/contact/{contact}', [App\Http\Controllers\ContactController::class, 'destroy'])->name('contact.destroy');

    //SOLICITUD
    Route::get('solicitud/list', [App\Http\Controllers\SolicitudController::class, 'index'])->name('solicitar.index');
    Route::post('solicitud/friendship', [App\Http\Controllers\SolicitudController::class, 'sendSolicitud'])->name('solicitar.store');
    Route::post('solicitud/acepted', [App\Http\Controllers\SolicitudController::class, 'acepted'])->name('solicitar.acepted');
    Route::delete('solicitud/canceled', [App\Http\Controllers\SolicitudController::class, 'canceled'])->name('solicitar.canceled'); Route::delete('removesolicitud/friendship', [App\Http\Controllers\SolicitudController::class, 'removeSolicitud'])->name('solicitar.delete');
    
    // CHAT
    Route::get('/chat/contact/{contact}', [App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat', [App\Http\Controllers\ChatController::class, 'store'])->name('chat.post');
    Route::delete('/chat/messages/deleteAll', [App\Http\Controllers\ChatController::class, 'destroyAllChatMessages'])->name('chat.destroy'); 
    Route::get('/chat/me-message/message={message_id}/chat={chat_id}/contact={contact}', [App\Http\Controllers\ChatController::class, 'destroyMessageMyChat'])->name('chat.me.destroy');
    Route::get('/chat/both-message/message={message_id}/chat={chat_id}-{chat2_id}//contact={contact}', [App\Http\Controllers\ChatController::class, 'destroyMessageBothChat'])->name('chat.both.destroy');
    
});
