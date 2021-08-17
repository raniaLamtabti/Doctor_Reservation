@extends('layouts.dashboard')

@section('content')

<main class="article authPages">

    <h3>Blog</h3>
    <a href="{{ route('admin.home') }}">Dashboard</a>

    <section class="content">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Create
        </button>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create article</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.articleCreate') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="form-group custom-file">
                            <input type="file" class="form-control custom-file-input" id="validatedCustomFile" required name="image">
                            <label class="form-control custom-file-label" for="validatedCustomFile">Choose file...</label>
                        </div>
                        <div class="form-group">
                            <label for="body">Body</label>
                            <textarea name="body" class="form-control" id="" cols="30" rows="8"></textarea>
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
                    <th>Image</th>
                    <th>Title</th>
                    <th>Likes</th>
                    <th>Comments</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach (App\Models\Article::get() as $article)
                <tr>
                    <td><img src="{{ asset($article->image) }}" alt="" width="200px" height="100px" style="border-radius: 10px"></td>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->likes }}</td>
                    <td>{{ App\Models\Comment::where('article_id',$article->id)->count('id')   }}</td>
                    <td class="action">
                        <form action="{{ route('admin.articleDelete', ['id' => $article->id]) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submite" class="actionBtn"><img src="{{ asset('images/Icon feather-trash.png') }}" alt=""></button>
                        </form>
                        <!-- Button trigger modal -->
                        <button type="button" class="actionBtn" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $article->id }}">
                            <img src="{{ asset('images/Icon feather-edit.png') }}" alt="">
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{ $article->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ $article->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.articleUpdate', ['id' => $article->id]) }}" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        @csrf
                                        <img src="{{ asset($article->image) }}" alt="" width="100%" height="300px" style="border-radius: 10px">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" name="title" value="{{ $article->title }}">
                                        </div>
                                        <div class="form-group custom-file">
                                            <input type="file" class="form-control custom-file-input" id="validatedCustomFile" required name="image"  value="{{ $article->image }}">
                                            <label class="form-control custom-file-label" for="validatedCustomFile">Choose file...</label>
                                        </div>
                                        <div class="form-group">
                                            <label for="body">Body</label>
                                            <textarea name="body" class="form-control" id="" cols="30" rows="8">{{ $article->body }}</textarea>
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
                    <a type="button" class="actionBtn" href="{{ route('showArticle', ['id' => $article->id]) }}">
                        <img src="{{ asset('images/Icon feather-more-horizontal.png') }}" alt="" class="dot">
                    </a>
                    </td>
                @endforeach
            </tbody>
        </table>
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
                <h4>Blog</h4><hr>
                @foreach (App\Models\Article::all() as $article)
                <div class="card">
                    <p>{{ $article->title }}</p>
                    <p>{{ $article->body }}</p>
                    <p>{{ $article->likes }}</p>
                    <p>{{ App\Models\Comment::where('article_id',$article->id)->count('id')}}</p>
                    <form action="{{ route('admin.articleDelete', ['id' => $article->id]) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submite" class="btn primary-btn">Delete</button>
                    </form>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $article->id }}">
                        Update
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal{{ $article->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ $article->id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin.articleUpdate', ['id' => $article->id]) }}" method="post">
                            <div class="modal-body">
                                <input type="hidden" name="_method" value="PUT">
                                {{ csrf_field() }}
                                <input type="text" name="title" value="{{ $article->title }}">
                                <textarea name="body" id="" cols="30" rows="10">{{ $article->body }}</textarea>
                                <input type="file" name="image" value="{{ $article->image }}">
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
                <form action="{{ route('admin.articleCreate') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="title">
                    <textarea name="body" id="" cols="30" rows="10"></textarea>
                    <input type="file" name="image">
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
