@extends('layouts.app')

@section('content')
<main class="container singleArticle">
    <section class="article">
        <h1>{{ $article->title }}</h1>
        <img src="{{ asset($article->image) }}" alt="">
        <span>{{ $article->created_at->toDateString()  }}</span>
        <p>{{ $article->body }}</p>
        <div class="count">
            <div class="elem">
                <img src="{{ asset('images/Icon awesome-heart.png') }}" alt="">
                {{ App\Models\Comment::where('article_id',$article->id)->count('id')   }}
            </div>
            <div class="elem">
                <img src="{{ asset('images/Icon material-insert-comment.png') }}" alt="">
                {{ $article->likes }}
            </div>
        </div>
    </section>
    <section class="comments">
        @foreach ($comments as $comment)
        <div class="commment">
            <h2>{{ App\Models\User::find($comment->user_id)->name }}</h2>
            <p>{{ $comment->body }}</p>
        </div>
        <hr>
        @endforeach
    </section>
    @auth
    <section class="addCommment">
        <form action="{{ route('admin.articleLike', ['id' => $article->id]) }}" method="post">
            <input type="hidden" name="_method" value="PUT">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-primary">Like</button>
        </form>
        <form action="{{ route('user.createComment') }}" method="post">
            @csrf
            <input type="text" name="article" hidden value="{{ $article->id }}">
            <div class="form-group">
                <label for="body" class="form-label">Inset your comment</label>
                <textarea name="body" class="form-control" id="" cols="30" rows="10"></textarea>
            </div>
            <button type="submit" class="btn btn-secondary text-light">Add comment</button>
        </form>
    </section>
    @endauth
</main>
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $article->title }}</div>
                <div class="card-body">
                    {{ $article->image }}
                    <p>{{ $article->created_at->toDateString()  }}</p>
                    <p>{{ $article->title }}</p>
                    <p>{{ $article->likes }}</p>
                    <p>{{ $article->body }}</p>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('admin.articleLike', ['id' => $article->id]) }}" method="post">
        <input type="hidden" name="_method" value="PUT">
        {{ csrf_field() }}
        <button type="submit" class="btn btn-primary">Like</button>
    </form>
    @foreach ($comments as $comment)
    <div class="card">
        <div class="card-header">{{ App\Models\User::find($comment->user_id)->name }}</div>
        <div class="card-body">
            <p>{{ $comment->body }}</p>
            <p>{{ $article->created_at->toDateString()  }}</p>
        </div>
    </div>
    @endforeach

    @auth
    <form action="{{ route('user.createComment') }}" method="post">
        @csrf
        <input type="text" name="article" hidden value="{{ $article->id }}">
        <div class="form-group">
            <label for="body">Comment</label>
            <textarea name="body" class="form-control" id="" cols="30" rows="10"></textarea>
        </div>
        <button type="submit">add</button>
    </form>
    @endauth
</div> --}}
@endsection
