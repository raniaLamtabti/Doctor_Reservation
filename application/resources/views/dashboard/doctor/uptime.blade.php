@extends('layouts.dashboard')

@section('content')

<main class="uptime authPages">

    <h3>Work Hours</h3>
    <a href="{{ route('doctor.home') }}">Dashboard</a>

    <section class="content">
        <div class="uptime">
            <h4>Upwtimes</h4>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Create
            </button>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('doctor.uptimeCreate') }}" method="post">
                        <div class="modal-body">
                            @csrf
                            <input type="time" name="morningFrom">
                            <input type="time" name="morningTo">
                            <input type="time" name="afternoonFrom">
                            <input type="time" name="afternoonTo">
                            <input type="time" name="eveningFrom">
                            <input type="time" name="eveningTo">
                            <div class="form-group">
                                <label for="days">days</label>
                                <select name="days[]" id="" class="form-select" multiple aria-label="multiple select example">
                                    <option disabled selected>Choose days</option>
                                    <option value="1" {{ !in_array('1', $days) ? 'disabled' : '' }}>M</option>
                                    <option value="2" {{ !in_array('2', $days) ? 'disabled' : '' }}>T</option>
                                    <option value="3" {{ !in_array('3', $days) ? 'disabled' : '' }}>w</option>
                                    <option value="4" {{ !in_array('4', $days) ? 'disabled' : '' }}>T</option>
                                    <option value="5" {{ !in_array('5', $days) ? 'disabled' : '' }}>F</option>
                                    <option value="6" {{ !in_array('6', $days) ? 'disabled' : '' }}>S</option>
                                    <option value="0" {{ !in_array('0', $days) ? 'disabled' : '' }}>S</option>
                                </select>
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
            <table id="example" class="table table-striped display table-bordered dt-responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>Morning start</th>
                        <th>Morning end</th>
                        <th>Afternoon start</th>
                        <th>Afternoon end</th>
                        <th>Evening start</th>
                        <th>Evening end</th>
                        <th>Days</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($uptimes as $uptime)
                    <tr>
                        <td>{{ $uptime->morningFrom }}</td>
                        <td>{{ $uptime->morningTo }}</td>
                        <td>{{ $uptime->afternoonFrom }}</td>
                        <td>{{ $uptime->afternoonTo }}</td>
                        <td>{{ $uptime->eveningFrom }}</td>
                        <td>{{ $uptime->eveningTo }}</td>
                        <td>{{ $uptime->days }}</td>
                        <td class="action">
                            <form action="{{ route('doctor.uptimeDelete', ['id' => $uptime->id]) }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submite" class="btn btn-danger text-light">Delete</button>
                            </form>
                        </td>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="vacation">
            <h4>Vacation</h4>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Create
            </button>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('doctor.vacationCreate') }}" method="post">
                        <div class="modal-body">
                            @csrf
                            <input type="date" name="start">
                            <input type="time" name="end">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <table id="example2" class="table table-striped display table-bordered dt-responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>Start</th>
                        <th>End</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vacations as $vacation)
                    <tr>
                        <td>{{ $vacation->start }}</td>
                        <td>{{ $vacation->end }}</td>
                        <td class="action">
                            <form action="{{ route('doctor.vacationDelete', ['id' => $vacation->id]) }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submite" class="btn btn-danger text-light">Delete</button>
                            </form>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-warning text-light" data-bs-toggle="modal" data-bs-target="#exampleModalV{{ $vacation->id }}">
                                Update
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalV{{ $vacation->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{ $vacation->id }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('doctor.vacationUpdate', ['id' => $vacation->id]) }}" method="post">
                                    <div class="modal-body">
                                        <input type="hidden" name="_method" value="PUT">
                                        {{ csrf_field() }}
                                        <input type="date" name="start" value="{{ $vacation->start }}">
                                        <input type="date" name="end" value="{{ $vacation->end }}">
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        </td>
                    @endforeach
                </tbody>
            </table>
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
    <title>Doctor Dashboard | Home</title>
    <link rel="stylesheet" href="{{ asset('bootstrap.min.css') }}">
</head>
<body style="background-color: #d7dadb">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3" style="margin-top: 45px">
                <h4>Uptime</h4><hr>
                @foreach (App\Models\Uptime::where('doctor_id',Auth::guard('doctor')->user()->id)->get() as $uptime)
                <div class="card">
                    <p>{{ $uptime->morningFrom }}</p>
                    <p>{{ $uptime->morningTo }}</p>
                    <p>{{ $uptime->afternoonFrom }}</p>
                    <p>{{ $uptime->afternoonTo}}</p>
                    <p>{{ $uptime->eveningFrom }}</p>
                    <p>{{ $uptime->eveningTo }}</p>
                    <p>{{ $uptime->days }}</p>
                    <form action="{{ route('doctor.uptimeDelete', ['id' => $uptime->id]) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submite" class="btn primary-btn">Delete</button>
                    </form>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $uptime->id }}">
                        Update
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal{{ $uptime->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ $uptime->id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('doctor.uptimeUpdate', ['id' => $uptime->id]) }}" method="post">
                            <div class="modal-body">
                                <input type="hidden" name="_method" value="PUT">
                                {{ csrf_field() }}
                                <input type="time" name="morningFrom" value="{{ $uptime->morningFrom }}">
                                <input type="time" name="morningTo" value="{{ $uptime->morningTo }}">
                                <input type="time" name="afternoonFrom" value="{{ $uptime->afternoonFrom }}">
                                <input type="time" name="afternoonTo" value="{{ $uptime->afternoonTo }}">
                                <input type="time" name="eveningFrom" value="{{ $uptime->eveningFrom }}">
                                <input type="time" name="eveningTo" value="{{ $uptime->eveningTo }}">
                                <div class="form-group">
                                    <label for="days">days</label>
                                    <select name="days[]" id="" class="form-select" multiple aria-label="multiple select example">
                                        <option disabled selected>Choose days</option>
                                        <option value="1" {{ in_array('1', explode('|', $uptime->days)) ? 'selected' : '' }}>M</option>
                                        <option value="2" {{ in_array('2', explode('|', $uptime->days)) ? 'selected' : '' }}>T</option>
                                        <option value="3" {{ in_array('3', explode('|', $uptime->days)) ? 'selected' : '' }}>w</option>
                                        <option value="4" {{ in_array('4', explode('|', $uptime->days)) ? 'selected' : '' }}>T</option>
                                        <option value="5" {{ in_array('5', explode('|', $uptime->days)) ? 'selected' : '' }}>F</option>
                                        <option value="6" {{ in_array('6', explode('|', $uptime->days)) ? 'selected' : '' }}>S</option>
                                        <option value="7" {{ in_array('7', explode('|', $uptime->days)) ? 'selected' : '' }}>S</option>
                                    </select>
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
                @endforeach
                <form action="{{ route('doctor.uptimeCreate') }}" method="post">
                    @csrf
                    <input type="text" name="doctor" hidden value="{{ Auth::guard('doctor')->user()->id }}">
                    <input type="time" name="morningFrom">
                    <input type="time" name="morningTo">
                    <input type="time" name="afternoonFrom">
                    <input type="time" name="afternoonTo">
                    <input type="time" name="eveningFrom">
                    <input type="time" name="eveningTo">
                    <div class="form-group">
                        <label for="days">days</label>
                        <select name="days[]" id="" class="form-select" multiple aria-label="multiple select example">
                            <option disabled selected>Choose days</option>
                            <option value="1">M</option>
                            <option value="2">T</option>
                            <option value="3">w</option>
                            <option value="4">T</option>
                            <option value="5">F</option>
                            <option value="6">S</option>
                            <option value="7">S</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
            <div class="col-md-6 offset-md-3" style="margin-top: 45px">
                <h4>vacation</h4><hr>
                @foreach (App\Models\Vacation::where('doctor_id',Auth::guard('doctor')->user()->id)->get() as $vacation)
                <div class="card">
                    <p>{{ $vacation->start }}</p>
                    <p>{{ $vacation->end }}</p>
                    <form action="{{ route('doctor.vacationDelete', ['id' => $vacation->id]) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submite" class="btn primary-btn">Delete</button>
                    </form>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalV{{ $vacation->id }}">
                        Update
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModalV{{ $vacation->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ $vacation->id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('doctor.vacationUpdate', ['id' => $vacation->id]) }}" method="post">
                            <div class="modal-body">
                                <input type="hidden" name="_method" value="PUT">
                                {{ csrf_field() }}
                                <input type="date" name="start" value="{{ $vacation->start }}">
                                <input type="date" name="end" value="{{ $vacation->end }}">
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
                <form action="{{ route('doctor.vacationCreate') }}" method="post">
                    @csrf
                    <input type="text" name="doctor" hidden value="{{ Auth::guard('doctor')->user()->id }}">
                    <input type="date" name="start">
                    <input type="date" name="end">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
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
