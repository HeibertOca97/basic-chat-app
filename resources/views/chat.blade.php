@extends('layouts.app')

@section('content')
    <div class="container-xl mt-4 mb-4 border">
        <div class="row">
            <div class="col-sm-4 border">
                {{-- <div class="row border">
                    <div class="col-sm-3">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRC6iPDSqcgCcAtdEz_rPY0B-sxqMd7hz0Hlg&usqp=CAU" class="img-fluid" alt="Perfil: {{Auth::user()->name}}">
                    </div>
                    <div class="col-sm-8">
                        <p><strong>Name: </strong>{{Auth::user()->name}}</p>
                        <p><strong>Email: </strong>{{Auth::user()->email}}</p>
                        <form action="{{route('logout')}}" method="post">
                            @csrf
                            @method("delete")
                            <button class="btn btn-danger m-2"><small>Cerrar sesion</small></button>
                        </form>
                        <a href="{{route('solicitar.index')}}" class="btn btn-secondary m-2">Solicitudes <span class="badge badge-light">{{count(Auth::user()->solicitudReceptor)}}</span></a>
                    </div>
                </div> --}}
                <div class="container mt-3 mb-3">
                    <h4 class="text-left">Chats</h4>
                </div>
                @foreach (Auth::user()->contact as $item)
                <div class="row border mb-1 p-2 @if ($chat->contact->contact->id == $item->contact->id) bg-secondary text-white @endif">
                    <div class="col-sm-3">
                        <img src="https://aumentada.net/wp-content/uploads/2015/05/user.png" class="img-fluid" alt="Perfil: {{$item->contact->name}}">
                    </div>
                    <div class="col-sm-8">
                        <p>{{$item->contact->name}}</p>
                        <a class="btn @if ($chat->contact->contact->id == $item->contact->id) btn-outline-light @else btn-outline-info @endif" href="{{route('chat.index', ['contact' => $item->contact])}}"><small>Escribir</small></a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="col-sm-8">

                <a href="{{route('dashboard')}}" class="btn btn-outline-dark m-2">Cerrar chat</a>
                <form action="{{ route('chat.destroy') }}" class="d-inline m-2" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="contact_id" value="{{ $contact->id }}">
                    <input type="hidden" name="chat_id" value="{{ $chat->id }}">
                    <button type="submit" class="btn btn-outline-danger">Vaciar chat</button>
                </form>
                <div class="border" id="box-msg" style="height:500px; max-height:520px; overflow: auto;">
                    @if (count($chat->message)>0)
                        
                    @foreach ($chat->message as $key => $item)
                    @if ($item->user_id != Auth::user()->id)
                    <div class="d-flex justify-content-start m-3">
                        <div class="col-sm-10 border rounded bg-white text-secondary p-2">
                            <div class="dropdown">
                                <button class="btn btn-outline-dark dropdown-toggle" type="button" id="dropdownMenuButton{{$key}}" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{$key}}">
                                    <a class="dropdown-item" href="{{ route('chat.me.destroy',[
                                        'message_id'=>$item->id,
                                        'chat_id'=>$item->chat_id,
                                        'contact'=>$contact->id
                                    ]) }}">Eliminar para mi</a>
                                </div>
                            </div>
                            <small class="text-left">{{$item->user->name}}</small>
                            <span class="text-left d-block">{{$item->mensaje}}</span>
                            <small class="text-right d-block">{{$item->created_at->format('H:i')}}</small>
                        </div>
                    </div>
                    @else
                    <div class="d-flex justify-content-end m-3">
                        <div class="col-sm-10 border rounded bg-primary text-white p-2">
                            <div class="dropdown">
                                <button class="btn btn-outline-dark dropdown-toggle" type="button" id="dropdownMenuButton{{$key}}" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{$key}}">
                                    <a class="dropdown-item" href="{{ route('chat.me.destroy',[
                                        'message_id'=>$item->id,
                                        'chat_id'=>$item->chat_id,
                                        'contact'=>$contact->id
                                    ]) }}">Eliminar para mi</a>
                                    <a class="dropdown-item" href="{{ route('chat.both.destroy', [
                                        'message_id'=>$item->id,
                                        'chat_id'=>$item->chat_id,
                                        'chat2_id'=>$chat2->id,
                                        'contact'=>$contact->id
                                    ]) }}">Eliminar para ambos</a>
                                </div>
                            </div>
                            <span class="text-left d-block">{{$item->mensaje}}</span>
                            <small class="text-right d-block">{{$item->created_at->format('H:i')}}</small>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    @else
                    <div class="ml-auto mr-auto mt-2 mb-2 col-sm-8 alert alert-warning" role="alert">
                        <small>Se el primero, comienza una conversacion con esta persona.</small>
                    </div>
                    @endif
                </div>
                <div class="">
                    <form action="{{route('chat.post')}}" method="post" class="row mt-2">
                        <div class="col-sm-10">
                            @csrf
                            <input type="hidden" name="contact" value="{{$contact->id}}">
                            <div class="form-group">
                                <textarea name="message" class="form-control" rows="3" style="max-height: 150px; min-height: 100px;" placeholder="Message write"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <button class="btn btn-outline-success m-2"><small>SEND</small></button>
                        </div>
        
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
