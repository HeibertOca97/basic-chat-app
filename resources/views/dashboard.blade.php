@extends('layouts.app')

@section('content')
    <div class="container-xl mt-4 mb-4 border">
        <div class="row">
            <div class="col-sm-4 border">
                <div class="row border p-2">
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
                        <a href="{{route('solicitar.index')}}" class="btn btn-secondary m-2"><small>Solicitudes</small> <span class="badge badge-light">{{count(Auth::user()->solicitudReceptor)}}</span></a>
                    </div>
                </div>
                <div class="container mt-3 mb-3">
                    <h4 class="text-left">Contactos</h4>
                </div>
                @foreach (Auth::user()->contact as $item)
                <div class="row border mb-1 p-2">
                    <div class="col-sm-3">
                        <img src="https://aumentada.net/wp-content/uploads/2015/05/user.png" class="img-fluid" alt="Perfil: {{$item->contact->name}}">
                    </div>
                    <div class="col-sm-8">
                        <p>{{$item->contact->name}}</p>
                        <a class="btn btn-outline-info" href="{{route('chat.index', ['contact' => $item->contact])}}"><small>Escribir</small></a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="col-sm-8">
                <div class="ml-auto mr-auto mt-2 mb-2 col-sm-8 alert alert-info" role="alert">
                    <small>Comienza a conversar con tus amigos, familiares y demas seres queridos.</small>
                </div>
                @if (session('success'))
                    <div class="alert alert-success mt-3 mb-3" role="alert">
                    {{session('success')}}
                    </div>
                @endif
                <h4 class="p-3">List Users</h4>
                
                <div class="mb-2">
                    <button type="button" id="btn-list-register" class="btn shadow">Registrados</button>
                    <button type="button" id="btn-list-contact" class="btn shadow">Mis contactos <span class="badge badge-primary badge-pill">{{count(Auth::user()->contact)}}</span></button>
                </div>

                <div class="group-list-user" data-name="list1">
                    <div class="border rounded p-3 mb-3 d-flex justify-content-start align-items-start flex-wrap" style="height:480px; max-height:500px; overflow:auto;">
                        @if (count($users)>0)
                        @foreach ($users as $item)
                        <div class="card m-1">
                            <div class="card-header">{{$item->name}}</div>
                            <div class="card-body">
                                @if (Auth::user()->contact()->where('user2_id', $item->id)->first())
                                    <div class="btn btn-secondary">Contactos</div>
                                @else
                                @if ($item->solicitudReceptor()->where('emisor_id', Auth::user()->id)->first())
                                    <form action="{{route('solicitar.delete')}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="receptor" value="{{$item->id}}">
                                        <button class="btn btn-dark">Cancelar solicitud</button>
                                    </form>
                                @else
                                    <form action="{{route('solicitar.store')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="receptor" value="{{$item->id}}">
                                        <button class="btn btn-primary">Agregar a contactos</button>
                                    </form>
                                @endif
                                @endif
                            </div>
                        </div>
                        @endforeach
                        @else
                            <p> <small>Por el momento no hay mas usuarios registrados</small> </p>
                        @endif
                    </div>
                </div>
                <div class="group-list-user" data-name="list2">
                    <div class="border rounded p-3 mb-3 d-flex justify-content-start align-items-start flex-wrap" style="height:480px; max-height:500px; overflow:auto;">
                        @if (count(Auth::user()->contact) > 0)
                            @foreach (Auth::user()->contact as $item)
                                <div class="card m-1">
                                    <div class="card-header">{{$item->contact->name}}</div>
                                    <div class="card-body">
                                        <form action="{{route('contact.destroy', ['contact' => $item->contact])}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-outline-danger" type="submit"><small>Eliminar contacto</small></button>
                                    </form>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p> <small>Por el momento no cuenta con ningun contacto</small> </p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection