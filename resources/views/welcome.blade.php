@extends('layouts.app')

@section('content')
<div class="container-xl mt-4 mb-2">
    <a href="{{route('signin')}}" class="btn btn-primary">Sign in</a>
    <a href="{{route('signup')}}" class="btn btn-dark">Sign up</a>
</div>
    <div class="container-xl mt-4 mb-4 border">
        <div class="row">
            <div class="col-sm-6">
                @foreach ($users as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{$item->name}}
                        <span class="badge badge-primary badge-pill">{{count($item->contact)}}</span>
                    </li>
                    @endforeach
            </div>
            <div class="col-sm-6">
                <h2 class="text-center text-primary">Chat list</h2>
                <img src="https://www.muycomputerpro.com/wp-content/uploads/2014/05/chats.jpg" class="img-fluid" alt="imagen web">
            </div>
        </div>
    </div>
@endsection