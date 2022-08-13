@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-center align-items-center" style="height:100vh;">
    <form action="{{route('signup.store')}}" method="post" class="border rounded pl-4 pr-4 pb-2 pt-4">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session("success"))
            <div class="alert alert-success">{{session("success")}}</div>
        @endif
        <div class="form-group">
            <label for="name">Names</label>
            <input name="name" type="text" class="form-control" id="name" autocomplete="off" value="{{old('name')}}">
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input name="email" type="email" class="form-control" id="email" autocomplete="off" value="{{old('email')}}">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input name="password" type="password" class="form-control" id="password" autocomplete="off" value="{{old('password')}}">
        </div>
        <div class="form-group">
            <label for="password_confirmation">Password confirm</label>
            <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" autocomplete="off" value="{{old('password_confirmation')}}">
        </div>
        <button type="submit" class="btn btn-primary">Sign up</button>
        <div class="form-group mt-2">
        <small>Si ya tienes una cuenta? <a href="{{route('signin')}}" class="link">Sign in</a> </small>
        </div>
    </form>
</div>
@endsection