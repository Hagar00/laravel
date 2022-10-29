@extends('layouts.app')

@section('title')post_changr @endsection

@section('content')


    <form method="post" action="{{ route('comments.update',['comment'=>$comment->id ])}}">
{{--        {{method_field('PUT')}}--}}

        @csrf
        @method('PUT')

        <input type="hidden" name="user_id" value="{{$comment->user_id}}">
        <input type="hidden" name="post_id" value="{{$comment->post_id}}">


        <div class="form-group">
            <label for="exampleFormControlTextarea1">Description</label>
            <textarea type="text" name="comment" class="form-control form-control-lg" rows="3">{{ $comment->comment }}</textarea>
        </div>


        <button type="submit" class="btn btn-primary btn-lg">update</button>
    </form>



@endsection


