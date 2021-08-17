@extends('layouts.app')

@section('content')
<section class="connect container">
    <section class="image">
        <img src="{{ asset('images/hero.png') }}" alt="">
    </section>
    <section class="form">
        <form action="{{ route('user.create') }}" method="post" autocomplete="off">
            @if (Session::get('success'))
                 <div class="alert alert-success">
                     {{ Session::get('success') }}
                 </div>
            @endif
            @if (Session::get('fail'))
            <div class="alert alert-danger">
                {{ Session::get('fail') }}
            </div>
            @endif

            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" placeholder="Enter full name" value="{{ old('name') }}">
                <span class="text-danger">@error('name'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" name="phone" placeholder="Enter phone number" value="{{ old('phone') }}">
                <span class="text-danger">@error('phone'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="cin">CIN</label>
                <input type="text" class="form-control" name="cin" placeholder="Enter cin" value="{{ old('cin') }}">
                <span class="text-danger">@error('cin'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" name="email" placeholder="Enter email address" value="{{ old('email') }}">
                <span class="text-danger">@error('email'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter password" value="{{ old('password') }}">
                <span class="text-danger">@error('password'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="cpassword">Confirm Password</label>
                <input type="password" class="form-control" name="cpassword" placeholder="Enter confirm password" value="{{ old('cpassword') }}">
                <span class="text-danger">@error('cpassword'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
            <br>
            <a href="{{ route('user.login') }}">I already have an account</a>
        </form>
    </section>
</section>

@endsection

