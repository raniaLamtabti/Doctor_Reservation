@extends('layouts.dashboard')

@section('content')

<main class="dashboard authPages">

    <h3>Appointments</h3>

    <section class="content">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">
                  <div class="stastistic">
                      <h3>{{ App\Models\Reservation::where('user_id',Auth::User()->id)->count() }}</h3>
                      <p>All</p>
                  </div>
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="today-tab" data-bs-toggle="tab" data-bs-target="#today" type="button" role="tab" aria-controls="today" aria-selected="false">
                <div class="stastistic">
                    <h3>{{ App\Models\Reservation::where('user_id',Auth::User()->id)->where('date',now()->toDateString())->count() }}</h3>
                    <p>Today</p>
                </div>
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="waiting-tab" data-bs-toggle="tab" data-bs-target="#waiting" type="button" role="tab" aria-controls="waiting" aria-selected="false">
                <div class="stastistic">
                    <h3>{{ App\Models\Reservation::where('user_id',Auth::User()->id)->whereDate('date','>',now()->toDateString())->count() }}</h3>
                    <p>Waiting</p>
                </div>
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="missed-tab" data-bs-toggle="tab" data-bs-target="#missed" type="button" role="tab" aria-controls="missed" aria-selected="false">
                <div class="stastistic">
                    <h3>{{ App\Models\Reservation::where('user_id',Auth::User()->id)->where('status','missed')->count() }}</h3>
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
                            <th>Doctor</th>
                            <th>Phone number</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (App\Models\Reservation::where('user_id',Auth::User()->id)->get() as $reservation)
                        <tr>
                            <td>{{ $reservation->code }}</td>
                            <td>{{ App\Models\Doctor::find($reservation->doctor_id)->name }}</td>
                            <td>{{ App\Models\Doctor::find($reservation->doctor_id)->phone }}</td>
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
                                    <img src="{{ asset('images/Icon feather-edit.png') }}" alt="">
                                </button>

                                <div class="modal fade" id="exampleModal{{ $reservation->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ $reservation->code }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('user.updateReservation', ['id' => $reservation->id]) }}" method="post">
                                        <div class="modal-body">
                                            <input type="hidden" name="_method" value="PUT">
                                            {{ csrf_field() }}
                                            <input type="text" name="doctor" hidden value="{{ $reservation->doctor_id }}">
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
                                <form action="{{ route('user.cancelReservation', ['id' => $reservation->id]) }}" method="post">
                                    <input type="hidden" name="_method" value="PUT">
                                    {{ csrf_field() }}
                                    <button type="submit" class="actionBtn"><img src="{{ asset('images/Icon feather-trash.png') }}" alt=""></button>
                                </form>
                                <button type="button" class="actionBtn" data-bs-toggle="modal" data-bs-target="#exampleModal{{ App\Models\Doctor::find($reservation->doctor_id)->id }}">
                                    <img src="{{ asset('images/Icon feather-more-horizontal.png') }}" alt="" class="dot">
                                </button>

                                <div class="modal fade" id="exampleModal{{ App\Models\Doctor::find($reservation->doctor_id)->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ App\Models\Doctor::find($reservation->doctor_id)->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body form-row"">
                                            <img src="{{ asset(App\Models\Doctor::find($reservation->doctor_id)->image) }}" alt="" width="100%" height="300px" style="border-radius: 10px">
                                            <div class="form-group col-md-12">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\Doctor::find($reservation->doctor_id)->name }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="phone">Phone</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\Doctor::find($reservation->doctor_id)->phone }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">email</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\Doctor::find($reservation->doctor_id)->email }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">City</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\City::find(App\Models\Doctor::find($reservation->doctor_id)->city_id)->name }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">specialty</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\Specialty::find(App\Models\Doctor::find($reservation->doctor_id)->specialty_id)->name }}">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="location">location</label>
                                                <textarea name="location" class="form-control" id="" readonly='true'>{{ App\Models\Doctor::find($reservation->doctor_id)->location }}</textarea>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="description">description</label>
                                                <textarea name="description" class="form-control" id="" readonly='true'>{{ App\Models\Doctor::find($reservation->doctor_id)->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
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
                        @foreach (App\Models\Reservation::where('user_id',Auth::User()->id)->where('date',now()->toDateString())->get() as $reservation)
                        <tr>
                            <td>{{ $reservation->code }}</td>
                            <td>{{ App\Models\Doctor::find($reservation->doctor_id)->name }}</td>
                            <td>{{ App\Models\Doctor::find($reservation->doctor_id)->phone }}</td>
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
                                    <img src="{{ asset('images/Icon feather-edit.png') }}" alt="">
                                </button>

                                <div class="modal fade" id="exampleModal{{ $reservation->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ $reservation->code }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('user.updateReservation', ['id' => $reservation->id]) }}" method="post">
                                        <div class="modal-body">
                                            <input type="hidden" name="_method" value="PUT">
                                            {{ csrf_field() }}
                                            <input type="text" name="doctor" hidden value="{{ $reservation->doctor_id }}">
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
                                <form action="{{ route('user.cancelReservation', ['id' => $reservation->id]) }}" method="post">
                                    <input type="hidden" name="_method" value="PUT">
                                    {{ csrf_field() }}
                                    <button type="submit" class="actionBtn"><img src="{{ asset('images/Icon feather-trash.png') }}" alt=""></button>
                                </form>
                                <button type="button" class="actionBtn" data-bs-toggle="modal" data-bs-target="#exampleModal{{ App\Models\Doctor::find($reservation->doctor_id)->id }}">
                                    <img src="{{ asset('images/Icon feather-more-horizontal.png') }}" alt="" class="dot">
                                </button>

                                <div class="modal fade" id="exampleModal{{ App\Models\Doctor::find($reservation->doctor_id)->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ App\Models\Doctor::find($reservation->doctor_id)->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body form-row"">
                                            <img src="{{ asset(App\Models\Doctor::find($reservation->doctor_id)->image) }}" alt="" width="100%" height="300px" style="border-radius: 10px">
                                            <div class="form-group col-md-12">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\Doctor::find($reservation->doctor_id)->name }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="phone">Phone</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\Doctor::find($reservation->doctor_id)->phone }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">email</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\Doctor::find($reservation->doctor_id)->email }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">City</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\City::find(App\Models\Doctor::find($reservation->doctor_id)->city_id)->name }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">specialty</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\Specialty::find(App\Models\Doctor::find($reservation->doctor_id)->specialty_id)->name }}">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="location">location</label>
                                                <textarea name="location" class="form-control" id="" readonly='true'>{{ App\Models\Doctor::find($reservation->doctor_id)->location }}</textarea>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="description">description</label>
                                                <textarea name="description" class="form-control" id="" readonly='true'>{{ App\Models\Doctor::find($reservation->doctor_id)->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (App\Models\Reservation::where('user_id',Auth::User()->id)->whereDate('date','>',now()->toDateString())->get() as $reservation)
                        <tr>
                            <td>{{ $reservation->code }}</td>
                            <td>{{ App\Models\Doctor::find($reservation->doctor_id)->name }}</td>
                            <td>{{ App\Models\Doctor::find($reservation->doctor_id)->phone }}</td>
                            <td>{{ $reservation->date }}</td>
                            <td>{{ $reservation->time }}</td>
                            <td class="action">
                                <button type="button" class="actionBtn" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $reservation->id }}">
                                    <img src="{{ asset('images/Icon feather-edit.png') }}" alt="">
                                </button>

                                <div class="modal fade" id="exampleModal{{ $reservation->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ $reservation->code }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('user.updateReservation', ['id' => $reservation->id]) }}" method="post">
                                        <div class="modal-body">
                                            <input type="hidden" name="_method" value="PUT">
                                            {{ csrf_field() }}
                                            <input type="text" name="doctor" hidden value="{{ $reservation->doctor_id }}">
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
                                <form action="{{ route('user.cancelReservation', ['id' => $reservation->id]) }}" method="post">
                                    <input type="hidden" name="_method" value="PUT">
                                    {{ csrf_field() }}
                                    <button type="submit" class="actionBtn"><img src="{{ asset('images/Icon feather-trash.png') }}" alt=""></button>
                                </form>
                                <button type="button" class="actionBtn" data-bs-toggle="modal" data-bs-target="#exampleModal{{ App\Models\Doctor::find($reservation->doctor_id)->id }}">
                                    <img src="{{ asset('images/Icon feather-more-horizontal.png') }}" alt="" class="dot">
                                </button>

                                <div class="modal fade" id="exampleModal{{ App\Models\Doctor::find($reservation->doctor_id)->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ App\Models\Doctor::find($reservation->doctor_id)->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body form-row"">
                                            <img src="{{ asset(App\Models\Doctor::find($reservation->doctor_id)->image) }}" alt="" width="100%" height="300px" style="border-radius: 10px">
                                            <div class="form-group col-md-12">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\Doctor::find($reservation->doctor_id)->name }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="phone">Phone</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\Doctor::find($reservation->doctor_id)->phone }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">email</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\Doctor::find($reservation->doctor_id)->email }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">City</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\City::find(App\Models\Doctor::find($reservation->doctor_id)->city_id)->name }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">specialty</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\Specialty::find(App\Models\Doctor::find($reservation->doctor_id)->specialty_id)->name }}">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="location">location</label>
                                                <textarea name="location" class="form-control" id="" readonly='true'>{{ App\Models\Doctor::find($reservation->doctor_id)->location }}</textarea>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="description">description</label>
                                                <textarea name="description" class="form-control" id="" readonly='true'>{{ App\Models\Doctor::find($reservation->doctor_id)->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </td>
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (App\Models\Reservation::where('user_id',Auth::User()->id)->where('status','missed')->get() as $reservation)
                        <tr>
                            <td>{{ $reservation->code }}</td>
                            <td>{{ App\Models\Doctor::find($reservation->doctor_id)->name }}</td>
                            <td>{{ App\Models\Doctor::find($reservation->doctor_id)->phone }}</td>
                            <td>{{ $reservation->date }}</td>
                            <td>{{ $reservation->time }}</td>
                            <td>
                                <button type="button" class="actionBtn" data-bs-toggle="modal" data-bs-target="#exampleModal{{ App\Models\Doctor::find($reservation->doctor_id)->id }}">
                                    <img src="{{ asset('images/Icon feather-more-horizontal.png') }}" alt="" class="dot">
                                </button>

                                <div class="modal fade" id="exampleModal{{ App\Models\Doctor::find($reservation->doctor_id)->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ App\Models\Doctor::find($reservation->doctor_id)->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body form-row"">
                                            <img src="{{ asset(App\Models\Doctor::find($reservation->doctor_id)->image) }}" alt="" width="100%" height="300px" style="border-radius: 10px">
                                            <div class="form-group col-md-12">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\Doctor::find($reservation->doctor_id)->name }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="phone">Phone</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\Doctor::find($reservation->doctor_id)->phone }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">email</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\Doctor::find($reservation->doctor_id)->email }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">City</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\City::find(App\Models\Doctor::find($reservation->doctor_id)->city_id)->name }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">specialty</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\Specialty::find(App\Models\Doctor::find($reservation->doctor_id)->specialty_id)->name }}">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="location">location</label>
                                                <textarea name="location" class="form-control" id="" readonly='true'>{{ App\Models\Doctor::find($reservation->doctor_id)->location }}</textarea>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="description">description</label>
                                                <textarea name="description" class="form-control" id="" readonly='true'>{{ App\Models\Doctor::find($reservation->doctor_id)->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
          </div>
    </section>

</main>

@endsection

