@extends('layouts.app')

@section('title')Post @endsection

@section('content')


<br><br>

<div class="card">
    <div class="card-header">
        Post Info
    </div>
    <div class="card-body">



        <div class="d-flex">
           <h5 class="card-title mr-2">Title :</h5> <p class="card-text">{{$post['title']}}</p>
        </div>
        <div class="d-flex">
            <h5 class="card-title mr-2">Description:</h5> <p class="card-text">{{$post['description']}}</p>
        </div>

        <div class="d-flex">
            <h5 class="card-title mr-2">Slug:</h5> <p class="card-text">{{$post['slug']}}</p>
        </div>

        <div class="d-flex">

            <img src="{{ asset('photos/'.$post->photo) }}" class="card-title mr-2" width="400px" height="300px">
        </div>




    </div>
</div>

<br><br>

<div class="card">
    <div class="card-header">
        Post Creator Info
    </div>
    <div class="card-body">
        <div class="d-flex">
            <h5 class="card-title mr-2">Name :</h5>
            <p class="card-text">{{$post->user->name}}</p>
        </div>
        <div class="d-flex">
            <h5 class="card-title mr-2">Email :</h5>
            <p class="card-text">{{$post->user->email}}</p>
        </div>

        <div class="d-flex">
            <h5 class="card-title mr-2">Created at :</h5> <p class="card-text">{{ $post->created_at->isoFormat('dddd Do [of] MMMM YYYY HH: mm: ss A' )}}</p>
        </div>

    </div>
</div>


<div class="card mt-4" >
    <div class="card-header">
        Comments
    </div>
    <div>

        @foreach($comments as $comment)

{{--                <div>--}}
{{--                    <span class="h6">{{$comment->user->name}}</span>--}}
{{--                    <span> :- {{ $comment->comment }}</span>--}}
{{--                </div>--}}
                @if($userid==$comment->user_id && $comment->post_id==$post->id)
                    <ul class="list-group">
                        <li class="list-group-item"><span class="h6">{{$comment->user->name}}</span>
                            <span> :  {{ $comment->comment }}..............</span>
                            <br><br>
                            <div class="d-flex">
                            <a href="{{ route('comments.edit', ['comment' => $comment]) }}" class="btn btn-primary me-1 mr-2 ml-2">Edit</a>
                            <a href="{{ route('posts.com', ['id' => $post['id']]) }}" class="btn btn-success me-1">Add other comment</a>
                            <form action="{{ route('comments.destroy', ['comment' => $comment] )}}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger">Delete</button>
                            </form>
                            </div>


                        </li>

                    </ul>

            @elseif($comment->post_id==$post->id)
                <ul class="list-group">
                    <li class="list-group-item"><span class="h6">{{$comment->user->name}}</span>
                        <span> :  {{ $comment->comment }}</span></li>

                </ul>
            @endif
        @endforeach

    </div>
</div>





@endsection
