@extends('layouts.app')

@section('content')
<div class="container-xl">
    <h4 class="p-3">Mis solictudes de contacto</h4>
    <a href="{{route('dashboard')}}" class="btn btn-outline-dark m-2">Volver</a>
    <div class="border rounded p-3 mb-3 d-flex justify-content-start align-items-start flex-wrap" style="height:480px; max-height:500px; overflow:auto;">
        @if (count(Auth::user()->solicitudReceptor)<1)
            <p> <small>Por el momento no tiene ninguna solicitud de contacto</small> </p>
        @else
            @foreach (Auth::user()->solicitudReceptor as $item)
            <div class="card">
                <div class="card-header">{{$item->emisor->name}}</div>
                <div class="card-body">
                    <p>Te invita a que lo aceptes como tu nuevo contacto.</p>
                    <div class="d-flex justify-content-around flew-wrap align-items-center">
                        <form action="{{route('solicitar.acepted')}}" method="post">
                            @csrf
                            <input type="hidden" name="solicitud" value="{{$item}}">
                            <button type="submit" class="btn btn-outline-success">Aceptar</button>
                        </form>
                        <form action="{{route('solicitar.canceled')}}" method="post">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="solicitud" value="{{$item}}">
                            <button type="submit" class="btn btn-outline-danger">Cancelar solicitud</button>
                        </form>
                        {{-- <a href="{{route('solicitar.acepted', $item)}}" class="btn btn-success">Aceptar</a>
                        <a href="{{route('solicitar.canceled', $item)}}" class="btn btn-dark">Cancelar solicitud</a> --}}
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</div>
@endsection