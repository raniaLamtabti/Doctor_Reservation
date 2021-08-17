@extends('layouts.app')

@section('content')

<main class="home container">

    <section class="hero">
        <div class="content">
            <h1>Join Us<br>To enjoy<br>Your health</h1>
            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
            <a href="{{ url('/apply') }}">I am a doctor</a>
        </div>
        <div class="image">
            <img src="{{ asset('images/hero.png') }}" alt="">
        </div>
    </section>

    <section class="search">
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

    <section class="features">
        <div class="feature">
            <div class="image">
                <img src="{{ asset('images/Icon feather-clock.png') }}" alt="">
            </div>
            <div class="content">
                <p>Lorem ipsum dolor sit<br> amet, consetetur.</p>
            </div>
        </div>
        <div class="feature">
            <div class="image">
                <img src="{{ asset('images/Icon awesome-calendar-check.png') }}" alt="">
            </div>
            <div class="content">
                <p>Lorem ipsum dolor sit<br> amet, consetetur.</p>
            </div>
        </div>
        <div class="feature">
            <div class="image">
                <img src="{{ asset('images/Icon map-search.png') }}" alt="">
            </div>
            <div class="content">
                <p>Lorem ipsum dolor sit<br> amet, consetetur.</p>
            </div>
        </div>
    </section>

    <section class="about">
        <div class="image">
            <img src="{{ asset('images/about.jpg') }}" alt="">
        </div>
        <div class="content">
            <h1>About Us</h1>
            <span>Lorem ipsum dolor sit amet, consetetur.</span>
            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed.</p>
            <a href="">See more</a>
        </div>
    </section>

    <section class="services">
        <div class="title">
            <h1>Our Service</h1>
            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy.</p>
        </div>
        <div class="elements">
            <div class="content">
                <div class="service">
                    <div class="imageS">
                        <img src="{{ asset('images/Icon feather-calendar.png') }}" alt="">
                    </div>
                    <div class="contentS">
                        <h1>Creation of appointments</h1>
                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore.</p>
                    </div>
                </div>
                <div class="service">
                    <div class="imageS">
                        <img src="{{ asset('images/Icon feather-calendar.png') }}" alt="">
                    </div>
                    <div class="contentS">
                        <h1>Creation of appointments</h1>
                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore.</p>
                    </div>
                </div>
                <div class="service">
                    <div class="imageS">
                        <img src="{{ asset('images/Icon feather-calendar.png') }}" alt="">
                    </div>
                    <div class="contentS">
                        <h1>Creation of appointments</h1>
                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore.</p>
                    </div>
                </div>
            </div>
            <div class="image">
                <img src="{{ asset('images/service.jpg') }}" alt="">
            </div>
        </div>
    </section>

    <section class="count">
        <div class="item">
            <div class="number">
                <p>{{ App\Models\Doctor::count('id') }}<span>+</span></p>
            </div>
            <p>Doctors</p>
        </div>
        <div class="item">
            <div class="number">
                <p>{{ App\Models\Specialty::count('id') }}<span>+</span></p>
            </div>
            <p>Specialty</p>
        </div>
        <div class="item">
            <div class="number">
                <p>{{ App\Models\User::count('id') }}<span>+</span></p>
            </div>
            <p>Users</p>
        </div>
    </section>

    <section class="blog">
        <div class="title">
            <h1>Blog</h1>
            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy.</p>
        </div>
        <div class="owl-carousel owl-theme articles">
            @foreach (App\Models\Article::latest()->take(18)->get() as $article)
            <div class="article item">
                <img src="{{ asset($article->image) }}" alt="">
                <span>{{ $article->created_at->toDateString()  }}</span>
                <h1>{{ $article->title }}</h1>
                <div class="count">
                    <div class="comments elem">
                        <img src="{{ asset('images/Icon material-insert-comment.png') }}" alt="">
                        <p>{{ App\Models\Comment::where('article_id',$article->id)->count('id')   }}</p>
                    </div>
                    <div class="likes elem">
                        <img src="{{ asset('images/Icon awesome-heart.png') }}" alt="">
                        <p>{{ $article->likes }}</p>
                    </div>
                </div>
                <p>{!! \Illuminate\Support\Str::limit($article->body, 100, '...') !!}</p>
                <a href="{{ route('showArticle', ['id' => $article->id]) }}">See more</a>
            </div>
            @endforeach
        </div>
        <a href="{{ route('index') }}">See More</a>
    </section>

</main>

@endsection
