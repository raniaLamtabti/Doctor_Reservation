@extends('layouts.app')

@section('content')

<main class="findDr container">

    <section class="search">
        <div class="image">
            <img src="{{ asset('images/findDr.png') }}" alt="">
        </div>
        <form action="{{ route('find') }}" method="post" autocomplete="off">
            @csrf
            <div class="inputs">
                <div class="form-group">
                    <div class="input">
                        <img src="{{ asset('images/Icon feather-user.png') }}" alt="">
                        <input type="text" name="doctor" placeholder="Doctor name">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input">
                        <img src="{{ asset('images/Icon material-location-on.png') }}" alt="">
                        <select name="city" id="">
                            <option disabled selected class="plsh">Choose city</option>
                            @foreach (App\Models\City::All() as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input">
                        <img src="{{ asset('images/Icon metro-profile.png') }}" alt="">
                        <select name="specialty" id="">
                            <option disabled selected>Choose specialty</option>
                            @foreach (App\Models\Specialty::All() as $specialty)
                                <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group button">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    </section>

    <p class="condition">* You can fill in only one field</p>

    <section class="result">
        <div class="title">
            <h1>See result</h1>
        </div>
        <div class="doctors">
            @foreach ($doctors as $doctor)
            <div class="doctor">
                <div class="image">
                    <img src="{{ asset($doctor->image) }}" alt="">
                </div>
                <div class="content">
                    <h1>Dr. {{ $doctor->name }}</h1>
                    <p>{{ App\Models\Specialty::find($doctor->specialty_id)->name }}</p>
                    <div class="social">
                        <a href=""><img src="{{ asset('images/Icon awesome-facebook-f.png') }}" alt=""></a>
                        <a href=""><img src="{{ asset('images/Icon awesome-twitter.png') }}" alt=""></a>
                        <a href=""><img src="{{ asset('images/Icon awesome-linkedin-in.png') }}" alt=""></a>
                        <a href=""><img src="{{ asset('images/Icon metro-instagram.png') }}" alt=""></a>
                    </div>
                    <a href="{{ route('show', ['id' => $doctor->id]) }}" class="seeMore">Make an appointment</a>
                </div>
            </div>
            @endforeach
        </div>
    </section>

</main>
{{--
<div class="row justify-content-center">
    @foreach ($doctors as $doctor)
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ $doctor->name }}</div>

            <div class="card-body">
                {{ $doctor->phone }}
                {{ $doctor->city }}
                {{ $doctor->location }}
                {{ $doctor->description }}
                <a href="{{ route('show', ['id' => $doctor->id]) }}">Appointment</a>
            </div>
        </div>
    </div>
    @endforeach
</div> --}}
@endsection
