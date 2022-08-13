@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-center align-items-center" style="height:100vh;">
    <form action="{{route('signin.auth')}}" method="post" class="border rounded pl-4 pr-4 pb-2 pt-4">
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
        <div class="form-group">
            <label for="email">Email address</label>
            <input name="email" type="email" class="form-control" id="email" autocomplete="off" value="{{old('email')}}">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input name="password" type="password" class="form-control" id="password" autocomplete="off" value="{{old('password')}}">
        </div>
        <button type="submit" class="btn btn-primary">Sign in</button>
        <div class="form-group mt-2">
        <small>Si aun no tienes una cuenta? <a href="{{route('signup')}}" class="link">Sign up</a> </small>
        </div>
    </form>
</div>
@endsection