@extends('layouts.dashboard')

@section('content')

<main class="dashboard authPages">

    <h3>Doctors</h3>

    <section class="content">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">
                  <div class="stastistic">
                      <h3>{{ App\Models\Doctor::count() }}</h3>
                      <p>All</p>
                  </div>
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="today-tab" data-bs-toggle="tab" data-bs-target="#today" type="button" role="tab" aria-controls="today" aria-selected="false">
                <div class="stastistic">
                    <h3>{{ App\Models\Doctor::where('status','accepted')->count() }}</h3>
                    <p>Accepted</p>
                </div>
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="waiting-tab" data-bs-toggle="tab" data-bs-target="#waiting" type="button" role="tab" aria-controls="waiting" aria-selected="false">
                <div class="stastistic">
                    <h3>{{ App\Models\Doctor::where('status','waiting')->count() }}</h3>
                    <p>Waiting</p>
                </div>
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="missed-tab" data-bs-toggle="tab" data-bs-target="#missed" type="button" role="tab" aria-controls="missed" aria-selected="false">
                <div class="stastistic">
                    <h3>{{ App\Models\Doctor::where('status','refused')->count() }}</h3>
                    <p>Refused</p>
                </div>
              </button>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                <table id="example" class="table table-striped display table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Doctor</th>
                            <th>Phone number</th>
                            <th>Date</th>
                            <th>Specialty</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (App\Models\Doctor::get() as $doctor)
                        <tr>
                            <td><img src="{{ asset($doctor->image) }}" alt="" width="70px" height="70px" style="border-radius: 10px"></td>
                            <td>{{ $doctor->name }}</td>
                            <td>{{ $doctor->phone }}</td>
                            <td>{{ $doctor->created_at->toDateString()  }}</td>
                            <td>{{ App\Models\Specialty::find($doctor->specialty_id)->name }}</td>
                            <td>
                                @if ($doctor->status == 'waiting')
                                    <p style="color:#fff;background-color:#54C1FB">
                                @elseif($doctor->status == 'accepted')
                                    <p style="color:#fff;background-color:#0CCD8A">
                                @elseif($doctor->status == 'refused')
                                    <p style="color:#fff;background-color:#FE6E6E">
                                @endif
                                {{ $doctor->status }}</p></td>
                            <td class="action">
                                <form action="{{ route('admin.acceptDoctor', ['id' => $doctor->id]) }}" method="post">
                                    <input type="hidden" name="_method" value="PUT">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn actionBtn"><img src="{{ asset('images/Icon feather-check.png') }}" alt=""></button>
                                </form>
                                <form action="{{ route('admin.rejectDoctor', ['id' => $doctor->id]) }}" method="post">
                                    <input type="hidden" name="_method" value="PUT">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn actionBtn"><img src="{{ asset('images/Icon feather-trash.png') }}" alt=""></button>
                                </form>

                                <button type="button" class="actionBtn" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $doctor->id }}">
                                    <img src="{{ asset('images/Icon feather-more-horizontal.png') }}" alt="" class="dot">
                                </button>

                                <div class="modal fade" id="exampleModal{{ $doctor->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ $doctor->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body form-row"">
                                            <img src="{{ asset($doctor->image) }}" alt="" width="100%" height="300px" style="border-radius: 10px">
                                            <div class="form-group col-md-12">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ $doctor->name }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="phone">Phone</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ $doctor->phone }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">email</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ $doctor->email }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">City</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\City::find($doctor->city_id)->name }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">specialty</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\Specialty::find($doctor->specialty_id)->name }}">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="location">location</label>
                                                <textarea name="location" class="form-control" id="" readonly='true'>{{ $doctor->location }}</textarea>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="description">description</label>
                                                <textarea name="description" class="form-control" id="" readonly='true'>{{ $doctor->description }}</textarea>
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
                            <th>Image</th>
                            <th>Doctor</th>
                            <th>Phone number</th>
                            <th>Date</th>
                            <th>Specialty</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (App\Models\Doctor::where('status','accepted')->get() as $doctor)
                        <td><img src="{{ asset($doctor->image) }}" alt="" width="70px" height="70px" style="border-radius: 10px"></td>
                            <td>{{ $doctor->name }}</td>
                            <td>{{ $doctor->phone }}</td>
                            <td>{{ $doctor->created_at->toDateString()  }}</td>
                            <td>{{ App\Models\Specialty::find($doctor->specialty_id)->name }}</td>
                            <td>
                                @if ($doctor->status == 'waiting')
                                    <p style="color:#fff;background-color:#54C1FB">
                                @elseif($doctor->status == 'accepted')
                                    <p style="color:#fff;background-color:#0CCD8A">
                                @elseif($doctor->status == 'refused')
                                    <p style="color:#fff;background-color:#FE6E6E">
                                @endif
                                {{ $doctor->status }}</p></td>
                            <td class="action">

                                <button type="button" class="actionBtn" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $doctor->id }}">
                                    <img src="{{ asset('images/Icon feather-more-horizontal.png') }}" alt="" class="dot">
                                </button>

                                <div class="modal fade" id="exampleModal{{ $doctor->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ $doctor->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body form-row"">
                                            <img src="{{ asset($doctor->image) }}" alt="" width="100%" height="300px" style="border-radius: 10px">
                                            <div class="form-group col-md-12">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ $doctor->name }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="phone">Phone</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ $doctor->phone }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">email</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ $doctor->email }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">City</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\City::find($doctor->city_id)->name }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">specialty</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\Specialty::find($doctor->specialty_id)->name }}">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="location">location</label>
                                                <textarea name="location" class="form-control" id="" readonly='true'>{{ $doctor->location }}</textarea>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="description">description</label>
                                                <textarea name="description" class="form-control" id="" readonly='true'>{{ $doctor->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </td>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="waiting" role="tabpanel" aria-labelledby="waiting-tab">
                <table id="example" class="table table-striped display table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Doctor</th>
                            <th>Phone number</th>
                            <th>Date</th>
                            <th>Specialty</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (App\Models\Doctor::where('status','waiting')->get() as $doctor)
                        <tr>
                            <td><img src="{{ asset($doctor->image) }}" alt="" width="70px" height="70px" style="border-radius: 10px"></td>
                            <td>{{ $doctor->name }}</td>
                            <td>{{ $doctor->phone }}</td>
                            <td>{{ $doctor->created_at->toDateString()  }}</td>
                            <td>{{ App\Models\Specialty::find($doctor->specialty_id)->name }}</td>
                            <td class="action">
                                <form action="{{ route('admin.acceptDoctor', ['id' => $doctor->id]) }}" method="post">
                                    <input type="hidden" name="_method" value="PUT">
                                    {{ csrf_field() }}
                                    <button type="submit" class="actionBtn"><img src="{{ asset('images/Icon feather-check.png') }}" alt=""></button>
                                </form>
                                <form action="{{ route('admin.rejectDoctor', ['id' => $doctor->id]) }}" method="post">
                                    <input type="hidden" name="_method" value="PUT">
                                    {{ csrf_field() }}
                                    <button type="submit" class="actionBtn"><img src="{{ asset('images/Icon feather-trash.png') }}" alt=""></button>
                                </form>
                                <button type="button" class="actionBtn" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $doctor->id }}">
                                    <img src="{{ asset('images/Icon feather-more-horizontal.png') }}" alt="" class="dot">
                                </button>

                                <div class="modal fade" id="exampleModal{{ $doctor->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ $doctor->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body form-row"">
                                            <img src="{{ asset($doctor->image) }}" alt="" width="100%" height="300px" style="border-radius: 10px">
                                            <div class="form-group col-md-12">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ $doctor->name }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="phone">Phone</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ $doctor->phone }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">email</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ $doctor->email }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">City</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\City::find($doctor->city_id)->name }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">specialty</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\Specialty::find($doctor->specialty_id)->name }}">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="location">location</label>
                                                <textarea name="location" class="form-control" id="" readonly='true'>{{ $doctor->location }}</textarea>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="description">description</label>
                                                <textarea name="description" class="form-control" id="" readonly='true'>{{ $doctor->description }}</textarea>
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
                            <th>Image</th>
                            <th>Doctor</th>
                            <th>Phone number</th>
                            <th>Date</th>
                            <th>Specialty</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (App\Models\Doctor::where('status','refused')->get() as $doctor)
                        <tr>
                            <td><img src="{{ asset($doctor->image) }}" alt="" width="70px" height="70px" style="border-radius: 10px"></td>
                            <td>{{ $doctor->name }}</td>
                            <td>{{ $doctor->phone }}</td>
                            <td>{{ $doctor->created_at->toDateString()  }}</td>
                            <td>{{ App\Models\Specialty::find($doctor->specialty_id)->name }}</td>
                            <td class="action">

                                <button type="button" class="actionBtn" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $doctor->id }}">
                                    <img src="{{ asset('images/Icon feather-more-horizontal.png') }}" alt="" class="dot">
                                </button>

                                <div class="modal fade" id="exampleModal{{ $doctor->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ $doctor->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body form-row"">
                                            <img src="{{ asset($doctor->image) }}" alt="" width="100%" height="300px" style="border-radius: 10px">
                                            <div class="form-group col-md-12">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ $doctor->name }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="phone">Phone</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ $doctor->phone }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">email</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ $doctor->email }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">City</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\City::find($doctor->city_id)->name }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">specialty</label>
                                                <input type="text" class="form-control" readOnly='true' value="{{ App\Models\Specialty::find($doctor->specialty_id)->name }}">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="location">location</label>
                                                <textarea name="location" class="form-control" id="" readonly='true'>{{ $doctor->location }}</textarea>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="description">description</label>
                                                <textarea name="description" class="form-control" id="" readonly='true'>{{ $doctor->description }}</textarea>
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

{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>admin Dashboard | Home</title>
    <link rel="stylesheet" href="{{ asset('bootstrap.min.css') }}">
</head>
<body style="background-color: #d7dadb">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3" style="margin-top: 45px">
                <h4>admin Dashboard</h4><hr>
                {{ Auth::guard('admin')->user()->name }}
                <a href="{{ route('admin.editAdmin', ['id' => Auth::guard('admin')->user()->id]) }}">Profile</a>
                <a href="{{ route('admin.blog', ['id' => Auth::guard('admin')->user()->id]) }}">Blog</a>
                <a href="{{ route('admin.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                <form action="{{ route('admin.logout') }}" method="post" class="d-none" id="logout-form">@csrf</form>
                 @foreach (App\Models\Doctor::all() as $doctor)
                <div class="card">
                    <p>{{ $doctor->name }}</p>
                    <p>{{ $doctor->phone }}</p>
                    <p>{{ $doctor->created_at->toDateString() }}</p>
                    <p>{{ $doctor->status }}</p>
                    <p>{{ App\Models\Specialty::find($doctor->specialty_id)->name  }}</p>
                    <form action="{{ route('admin.acceptDoctor', ['id' => $doctor->id]) }}" method="post">
                        <input type="hidden" name="_method" value="PUT">
                        {{ csrf_field() }}
                        <button type="submit" class="btn primary-btn">Accepted</button>
                    </form>
                    <form action="{{ route('admin.rejectDoctor', ['id' => $doctor->id]) }}" method="post">
                        <input type="hidden" name="_method" value="PUT">
                        {{ csrf_field() }}
                        <button type="submit" class="btn primary-btn">Rejecter</button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html> --}}
