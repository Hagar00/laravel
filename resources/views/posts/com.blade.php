@extends('layouts.app')

@section('title') Create @endsection

@section('content')

    <form method="POST" action="{{ route('comments.store') }}">

        @csrf

        <input type="hidden" name="id" value="{{$post_id}}">




        <div class="mb-3">
            <label for="description" class="form-label">comment</label>
            <textarea class="form-control" name="addcomm" id="description" rows="3" > </textarea>
        </div>

        <div class="mb-3">
            <label for="post_creator" class="form-label">Post Creator</label>
            <select name="post_creator" class="form-control" id="post_creator" >

                    <option  value="{{$user->id}}" >{{$user->name}}</option>

            </select>
        </div>

        <button class="btn btn-success">Add comment</button>
    </form>
@endsection
