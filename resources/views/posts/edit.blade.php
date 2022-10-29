@extends('layouts.app')

@section('title')post_changr @endsection

@section('content')


    <form method="post" action="{{ route('posts.update',['post'=>$post['id']]) }}">
        {{method_field('PUT')}}
        @csrf
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="Post_title" class="form-control" value="{{  $post['title']  }}">
        </div>


        <div class="form-group">
            <label for="exampleFormControlTextarea1">Description</label>
            <textarea type="text" name="Post_dec" class="form-control form-control-lg" rows="3" >{{ $post['description'] }}</textarea>
        </div>

        <div class="form-group">
            <label>Post Creator</label>
            <select class="form-control"  name="Post_auther" >

                       <option value="{{$post->user->id}}">{{ $post->user->name }}</option>


            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-lg">update</button>
    </form>



@endsection

