@extends('layouts.dashboard')

@section('content')

<main class="profile authPages">

    <h3>Profile</h3>
    <a href="{{ route('user.home') }}">Dashboard</a>

    <section class="content">
        <form action="{{ route('user.userUpdate', ['id' => $user->id]) }}" method="post" class="form-row">
            <input type="hidden" name="_method" value="PUT">
            {{ csrf_field() }}
            <input type="text" name="user" hidden value="{{ $user->id }}">
            <div class="form-group col-md-6">
                <label for="inputEmail4">Name</label>
                <input type="text" name="name" value="{{ $user->name }}" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">CIN</label>
                <input type="text" name="cin" value="{{ $user->cin }}" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">Phone</label>
                <input type="text" name="phone" value="{{ $user->phone }}" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail4">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="form-control">
            </div>
            <div class="form-group col-md-12">
                <button type="submit" class="btn btn-primary form-control">Save changes</button>
            </div>
        </form>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-secondary text-light btn-block" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Update  Psw
        </button>
        @if (Session::get('fail'))
        <div class="alert alert-danger">
            {{ Session::get('fail') }}
        </div>
        @endif

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $user->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('user.userPassword', ['id' => $user->id]) }}" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="_method" value="PUT">
                        {{ csrf_field() }}
                        <input type="text" name="doctor" hidden value="{{ $user->id }}">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="newPassword">New Password</label>
                            <input type="password" name="newPassword" required class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

</main>

@endsection


{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Dashboard | Home</title>
    <link rel="stylesheet" href="{{ asset('bootstrap.min.css') }}">
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3" style="margin-top: 45px">
                <form action="{{ route('user.userUpdate', ['id' => $user->id]) }}" method="post">
                    <input type="hidden" name="_method" value="PUT">
                    {{ csrf_field() }}
                    <input type="text" name="user" hidden value="{{ $user->id }}">
                    <input type="text" name="name" value="{{ $user->name }}">
                    <input type="text" name="cin" value="{{ $user->cin }}">
                    <input type="text" name="phone" value="{{ $user->phone }}">
                    <input type="email" name="email" value="{{ $user->email }}">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
            @if (Session::get('fail'))
                <div class="alert alert-danger">
                    {{ Session::get('fail') }}
                </div>
            @endif
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Update  Psw
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $user->code }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('user.userPassword', ['id' => $user->id]) }}" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="_method" value="PUT">
                        {{ csrf_field() }}
                        <input type="text" name="doctor" hidden value="{{ $user->id }}">
                        <input type="password" name="password" required>
                        <input type="password" name="newPassword">
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
</body>
</html> --}}
