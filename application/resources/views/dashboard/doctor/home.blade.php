@extends('layouts.dashboard')

@section('content')

<main class="dashboard authPages">

    <h3>Appointments</h3>

    <section class="content">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">
                  <div class="stastistic">
                      <h3>{{ App\Models\Reservation::where('doctor_id',Auth::User()->id)->count() }}</h3>
                      <p>All</p>
                  </div>
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="today-tab" data-bs-toggle="tab" data-bs-target="#today" type="button" role="tab" aria-controls="today" aria-selected="false">
                <div class="stastistic">
                    <h3>{{ App\Models\Reservation::where('doctor_id',Auth::User()->id)->where('date',now()->toDateString())->count() }}</h3>
                    <p>Today</p>
                </div>
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="waiting-tab" data-bs-toggle="tab" data-bs-target="#waiting" type="button" role="tab" aria-controls="waiting" aria-selected="false">
                <div class="stastistic">
                    <h3>{{ App\Models\Reservation::where('doctor_id',Auth::User()->id)->whereDate('date','>',now()->toDateString())->count() }}</h3>
                    <p>Waiting</p>
                </div>
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="missed-tab" data-bs-toggle="tab" data-bs-target="#missed" type="button" role="tab" aria-controls="missed" aria-selected="false">
                <div class="stastistic">
                    <h3>{{ App\Models\Reservation::where('doctor_id',Auth::User()->id)->where('status','missed')->count() }}</h3>
                    <p>Missed</p>
                </div>
              </button>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                <table id="example" class="table table-striped display table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>CIN</th>
                            <th>Name</th>
                            <th>Phone number</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (App\Models\Reservation::where('doctor_id',Auth::User()->id)->get() as $reservation)
                        <tr>
                            <td>{{ $reservation->code }}</td>
                            <td>{{ App\Models\User::find($reservation->user_id)->CIN }}</td>
                            <td>{{ App\Models\User::find($reservation->user_id)->name }}</td>
                            <td>{{ App\Models\User::find($reservation->user_id)->phone }}</td>
                            <td>{{ $reservation->date }}</td>
                            <td>{{ $reservation->time }}</td>
                            <td>
                                @if ($reservation->status == 'waiting')
                                    <p style="color:#fff;background-color:#54C1FB">
                                @elseif($reservation->status == 'done')
                                    <p style="color:#fff;background-color:#0CCD8A">
                                @elseif($reservation->status == 'missed')
                                    <p style="color:#fff;background-color:#FE6E6E">
                                @endif
                                {{ $reservation->status }}</p></td>
                            <td class="action">
                                <button type="button" class="actionBtn" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $reservation->id }}">
                                    <img src="{{ asset('images/Icon feather-check.png') }}" alt="">
                                </button>

                                <div class="modal fade" id="exampleModal{{ $reservation->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ $reservation->code }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('doctor.doneReservation', ['id' => $reservation->id]) }}" method="post">
                                        <div class="modal-body">
                                            <input type="hidden" name="_method" value="PUT">
                                            {{ csrf_field() }}
                                            <input type="text" name="doctor" hidden value="{{ $reservation->user_id }}">
                                            <input type="date" name="date" value="{{ $reservation->date }}">
                                            <input type="time" name="time" value="{{ $reservation->time }}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                        </form>
                                    </div>
                                    </div>
                                </div>
                                <form action="{{ route('doctor.missedReservation', ['id' => $reservation->id]) }}" method="post">
                                    <input type="hidden" name="_method" value="PUT">
                                    {{ csrf_field() }}
                                    <button type="submit" class="actionBtn"><img src="{{ asset('images/Icon material-call-missed.png') }}" alt=""></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="today" role="tabpanel" aria-labelledby="today-tab">
                <table id="example" class="table table-striped display table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Doctor</th>
                            <th>Phone number</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (App\Models\Reservation::where('doctor_id',Auth::User()->id)->where('date',now()->toDateString())->get() as $reservation)
                        <tr>
                            <td>{{ $reservation->code }}</td>
                            <td>{{ App\Models\User::find($reservation->user_id)->CIN }}</td>
                            <td>{{ App\Models\User::find($reservation->user_id)->name }}</td>
                            <td>{{ App\Models\User::find($reservation->user_id)->phone }}</td>
                            <td>{{ $reservation->date }}</td>
                            <td>{{ $reservation->time }}</td>
                            <td>
                                @if ($reservation->status == 'waiting')
                                    <p style="color:#fff;background-color:#54C1FB">
                                @elseif($reservation->status == 'done')
                                    <p style="color:#fff;background-color:#0CCD8A">
                                @elseif($reservation->status == 'missed')
                                    <p style="color:#fff;background-color:#FE6E6E">
                                @endif
                                {{ $reservation->status }}</p></td>
                                <td class="action">
                                    <button type="button" class="actionBtn" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $reservation->id }}">
                                        <img src="{{ asset('images/Icon feather-check.png') }}" alt="">
                                    </button>

                                    <div class="modal fade" id="exampleModal{{ $reservation->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">{{ $reservation->code }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('doctor.doneReservation', ['id' => $reservation->id]) }}" method="post">
                                            <div class="modal-body">
                                                <input type="hidden" name="_method" value="PUT">
                                                {{ csrf_field() }}
                                                <input type="text" name="doctor" hidden value="{{ $reservation->user_id }}">
                                                <input type="date" name="date" value="{{ $reservation->date }}">
                                                <input type="time" name="time" value="{{ $reservation->time }}">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                            </form>
                                        </div>
                                        </div>
                                    </div>
                                    <form action="{{ route('doctor.missedReservation', ['id' => $reservation->id]) }}" method="post">
                                        <input type="hidden" name="_method" value="PUT">
                                        {{ csrf_field() }}
                                        <button type="submit" class="actionBtn"><img src="{{ asset('images/Icon material-call-missed.png') }}" alt=""></button>
                                    </form>
                                </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="waiting" role="tabpanel" aria-labelledby="waiting-tab">
                <table id="example" class="table table-striped display table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Doctor</th>
                            <th>Phone number</th>
                            <th>Date</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (App\Models\Reservation::where('doctor_id',Auth::User()->id)->whereDate('date','>',now()->toDateString())->get() as $reservation)
                        <tr>
                            <td>{{ $reservation->code }}</td>
                            <td>{{ App\Models\User::find($reservation->user_id)->CIN }}</td>
                            <td>{{ App\Models\User::find($reservation->user_id)->name }}</td>
                            <td>{{ App\Models\User::find($reservation->user_id)->phone }}</td>
                            <td>{{ $reservation->date }}</td>
                            <td>{{ $reservation->time }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="missed" role="tabpanel" aria-labelledby="missed-tab">
                <table id="example" class="table table-striped display table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Doctor</th>
                            <th>Phone number</th>
                            <th>Date</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (App\Models\Reservation::where('doctor_id',Auth::User()->id)->where('status','missed')->get() as $reservation)
                        <tr>
                            <td>{{ $reservation->code }}</td>
                            <td>{{ App\Models\User::find($reservation->user_id)->CIN }}</td>
                            <td>{{ App\Models\User::find($reservation->user_id)->name }}</td>
                            <td>{{ App\Models\User::find($reservation->user_id)->phone }}</td>
                            <td>{{ $reservation->date }}</td>
                            <td>{{ $reservation->time }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
    <title>Doctor Dashboard | Home</title>
    <link rel="stylesheet" href="{{ asset('bootstrap.min.css') }}">
</head>
<body style="background-color: #d7dadb">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3" style="margin-top: 45px">
                <h4>Doctor Dashboard</h4><hr>
                {{ Auth::guard('doctor')->doctor()->name }}
                <a href="{{ route('doctor.editDoctor', ['id' => Auth::guard('doctor')->user()->id]) }}">Profile</a>
                <a href="{{ route('doctor.uptime', ['id' => Auth::guard('doctor')->user()->id]) }}">Work time</a>
                <a href="{{ route('doctor.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                <form action="{{ route('doctor.logout') }}" method="post" class="d-none" id="logout-form">@csrf</form>
                 @foreach (App\Models\Reservation::where('doctor_id',Auth::guard('doctor')->user()->id)->get() as $reservation)
                <div class="card">
                    <p>{{ $reservation->code }}</p>
                    <p>{{ App\Models\User::find($reservation->user_id)->name }}</p>
                    <p>{{ App\Models\User::find($reservation->user_id)->phone }}</p>
                    <p>{{ App\Models\User::find($reservation->user_id)->cin }}</p>
                    <p>{{ $reservation->date }}</p>
                    <p>{{ $reservation->time }}</p>
                    <p>{{ $reservation->status }}</p>
                    <form action="{{ route('doctor.doneReservation', ['id' => $reservation->id]) }}" method="post">
                        <input type="hidden" name="_method" value="PUT">
                        {{ csrf_field() }}
                        <button type="submit" class="btn primary-btn">Done</button>
                    </form>
                    <form action="{{ route('doctor.missedReservation', ['id' => $reservation->id]) }}" method="post">
                        <input type="hidden" name="_method" value="PUT">
                        {{ csrf_field() }}
                        <button type="submit" class="btn primary-btn">Missed</button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html> --}}
