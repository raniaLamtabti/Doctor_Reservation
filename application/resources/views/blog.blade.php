@extends('layouts.app')

@section('content')
<main class="container blog articlesBlog">
    <section class="title">
        <h1>Blog</h1>
        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy.</p>
    </section>
    <section class="articles">
        @foreach ($articles as $article)
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
    </section>
</main>>
@endsection
