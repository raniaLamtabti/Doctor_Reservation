@extends('layouts.dashboard')

@section('content')

<main class="profile authPages">

    <h3>Profile</h3>
    <a href="{{ route('doctor.home') }}">Dashboard</a>

    <section class="content">
        <form action="{{ route('doctor.doctorUpdate', ['id' => $doctor->id]) }}" method="post" class="form-row">
            <input type="hidden" name="_method" value="PUT">
            {{ csrf_field() }}
            <input type="text" name="doctor" hidden value="{{ $doctor->id }}">
            <div class="form-group col-md-6">
                <label for="name">Name</label>
                <input type="text" class="form-control" value="{{ $doctor->name }}" name="name" placeholder="name">
            </div>
            <div class="form-group col-md-6">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" value="{{ $doctor->phone }}" name="phone" placeholder="phone">
            </div>
            <div class="form-group col-md-6">
                <label for="email">email</label>
                <input type="text" class="form-control" value="{{ $doctor->email }}" name="email" placeholder="email">
            </div>
            <div class="form-group col-md-6">
                <label>Image</label>
                <div class="custom-file">
                    <input type="file" class="form-control custom-file-input" id="validatedCustomFile" name="image" value="{{ $doctor->image }}"/>
                    <label class="form-control custom-file-label" for="validatedCustomFile">Choose file...</label>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="location">location</label>
                <textarea name="location" class="form-control" id="" cols="30" rows="10">{{ $doctor->location }}</textarea>
            </div>
            <div class="form-group col-md-6">
                <label for="description">description</label>
                <textarea name="description" class="form-control" id="" cols="30" rows="10">{{ $doctor->description }}</textarea>
            </div>
            <div class="form-group col-md-6">
                <label for="city">city</label>
                <select name="city" id="" class="form-control">
                    <option disabled selected>Choose city</option>
                    @foreach (App\Models\City::All() as $city)
                        <option value="{{ $city->id }}" {{ ($doctor->city_id) ==  ($city->id) ? 'selected' : '' }} >{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="specialty">specialty</label>
                <select name="specialty" id="" class="form-control">
                    <option disabled selected>Choose specialty</option>
                    @foreach (App\Models\Specialty::All() as $specialty)
                        <option value="{{ $specialty->id }}" {{ ($doctor->specialty_id) ==  ($specialty->id) ? 'selected' : '' }}>{{ $specialty->name }}</option>
                    @endforeach
                </select>
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
                        <h5 class="modal-title" id="exampleModalLabel">{{ $doctor->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('doctor.doctorPassword', ['id' => $doctor->id]) }}" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="_method" value="PUT">
                        {{ csrf_field() }}
                        <input type="text" name="doctor" hidden value="{{ $doctor->id }}">
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
    <title>doctor Dashboard | Home</title>
    <link rel="stylesheet" href="{{ asset('bootstrap.min.css') }}">
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3" style="margin-top: 45px">
                <form action="{{ route('doctor.doctorUpdate', ['id' => $doctor->id]) }}" method="post">
                    <input type="hidden" name="_method" value="PUT">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" value="{{ $doctor->name }}" name="name" placeholder="name">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" value="{{ $doctor->phone }}" name="phone" placeholder="phone">
                    </div>
                    <div class="form-group">
                        <label for="email">email</label>
                        <input type="text" class="form-control" value="{{ $doctor->email }}" name="email" placeholder="email">
                    </div>
                    <div class="form-group">
                        <label for="image">image</label>
                        <input type="file" class="form-control" name="image" placeholder="image">
                    </div>
                    <div class="form-group">
                        <label for="location">location</label>
                        <textarea name="location" class="form-control" id="" cols="30" rows="10">{{ $doctor->location }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="description">description</label>
                        <textarea name="description" class="form-control" id="" cols="30" rows="10">{{ $doctor->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="city">city</label>
                        <select name="city" id="" class="form-control">
                            <option disabled selected>Choose city</option>
                            @foreach (App\Models\City::All() as $city)
                                <option value="{{ $city->id }}" {{ ($doctor->city_id) ==  ($city->id) ? 'selected' : '' }} >{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="specialty">specialty</label>
                        <select name="specialty" id="" class="form-control">
                            <option disabled selected>Choose specialty</option>
                            @foreach (App\Models\Specialty::All() as $specialty)
                                <option value="{{ $specialty->id }}" {{ ($doctor->specialty_id) ==  ($specialty->id) ? 'selected' : '' }}>{{ $specialty->name }}</option>
                            @endforeach
                        </select>
                    </div>
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
                    <h5 class="modal-title" id="exampleModalLabel">{{ $doctor->code }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('doctor.doctorPassword', ['id' => $doctor->id]) }}" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="_method" value="PUT">
                        {{ csrf_field() }}
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
