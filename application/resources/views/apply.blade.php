@extends('layouts.app')

@section('content')
<main class="apply container">
    <form action="{{ route('storeDoctor') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="top-inputs">
            <div class="form-group">
                <img src="{{ asset('images/Icon feather-user.png') }}" alt="">
                <input type="text" class="form-control" name="name" placeholder="name">
            </div>
            <div class="form-group">
                <img src="{{ asset('images/Icon feather-phone.png') }}" alt="">
                <input type="text" class="form-control" name="phone" placeholder="phone">
            </div>
            <div class="form-group">
                <img src="{{ asset('images/Icon feather-mail.png') }}" alt="">
                <input type="text" class="form-control" name="email" placeholder="email">
            </div>
            <div class="form-group custom-file">
                <input type="file" class="form-control custom-file-input" id="validatedCustomFile" required>
                <label class="form-control custom-file-label" for="validatedCustomFile">Choose file...</label>
            </div>
            <div class="form-group">
                <img src="{{ asset('images/Icon material-location-on.png') }}" alt="">
                <select name="city" id="" class="form-control">
                    <option disabled selected>Choose city</option>
                    @foreach (App\Models\City::All() as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <img src="{{ asset('images/Icon metro-profile.png') }}" alt="">
                <select name="specialty" id="" class="form-control">
                    <option disabled selected>Choose specialty</option>
                    @foreach (App\Models\Specialty::All() as $specialty)
                        <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="bottom-inputs">
            <div class="form-group">
                <img src="{{ asset('images/Icon material-location-on.png') }}" alt="">
                <textarea name="location" class="form-control" id="" cols="30" rows="8"></textarea>
            </div>
            <div class="form-group">
                <img src="{{ asset('images/Icon material-location-on.png') }}" alt="">
                <textarea name="description" class="form-control" id="" cols="30" rows="8"></textarea>
            </div>
        </div>
        <div class="btnS">
            <button type="submit" class="">Apply</button>
        </div>
    </form>
</main>
@endsection
