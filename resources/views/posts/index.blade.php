@extends('layouts.app')

@section('title')Home @endsection

@section('content')
    <div class="text-center">
       <a href="{{route('posts.create')}}"> <button type="button" class="mt-4 btn btn-success">Create Post</button></a>
    </div>
    <table class="table mt-4">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Posted By</th>
            <th scope="col">Created At</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ( $posts as $post)

            <tr>
                <td>{{ $post->id }}</th>
                <td>{{ $post['title'] }}</td>
                <td>{{ $post->user->name }}</td>
                <td>{{ $post->created_at->isoFormat('YYYY-MM-DD' ) }}</td>


                @if(!isset($post->deleted_at))
                    <td class="d-flex">
                        <a href="{{ route('posts.show', ['post' => $post->id]) }}" class="btn btn-info me-1">View</a>
                        <a href="{{ route('posts.edit', ['post' => $post['id']]) }}" class="btn btn-primary me-1 mr-2 ml-2">Edit</a>
                        <a href="{{ route('posts.com', ['id' => $post['id']]) }}" class="btn btn-success me-1">Comments</a>
                        <form action="{{ route('posts.destroy', ['post'=> $post->id] )}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                @else
                    <td class="d-flex">
                        <a href="{{ route('posts.restore', ['post' => $post['id']]) }}" class="btn btn-warning me-1 mr-2 ml-2">Restore</a>
                        <form action="{{ route('posts.force_destroy', ['post'=> $post->id] )}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" onclick="return confirm('Are you sure to delete forever?')" class="btn btn-danger">Force Delete</button>
                        </form>
                    </td>
                @endif



            </tr>
        @endforeach

        </tbody>
    </table>
{{--    <nav aria-label="Page navigation example">--}}
{{--        <ul class="pagination">--}}
{{--            <li class="page-item"><a class="page-link" href="{{ route('posts.paginate', ['page'=>1]) }}">Previous</a></li>--}}
{{--            <li class="page-item"><a class="page-link" href="{{ route('posts.paginate', ['page'=>2]) }}">1</a></li>--}}
{{--            <li class="page-item"><a class="page-link" href="{{ route('posts.paginate', ['page'=>3]) }}">2</a></li>--}}
{{--            <li class="page-item"><a class="page-link" href="{{ route('posts.paginate', ['page'=>4]) }}">3</a></li>--}}
{{--            <li class="page-item"><a class="page-link" href="{{ route('posts.paginate', ['page'=>5]) }}">Next</a></li>--}}
{{--        </ul>--}}
{{--    </nav>--}}
    {{$posts->links()}}
@endsection

