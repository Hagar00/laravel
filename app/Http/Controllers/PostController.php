<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function return_posts(){

        return $posts=Post::all();
    }
    public function index()
    {
        $posts = Post::paginate(4);

       // dd($posts);
        return view('posts.index',[
            'posts' => $posts,
        ]);
    }


//    public function paginate($page) {
//        $per_page = 7;
//        $posts = Post::withTrashed()->paginate($per_page); //, ['*'], 'page', $page
//        return view("posts.index", [
//            'posts' => $posts
//        ]);
//    }

    public function create()
    {
        $users=User::all();

        return view('posts.create',['users'=>$users]);
    }

    public function store(StorePostRequest $request)
    {
        $this->validate(request(),[

            'photo' => 'required|mimes:jpeg,png,bmp',

        ]);
       // dd($request);
        //save photo
        $file_extension=$request -> photo -> getClientOriginalExtension();
        $file_name=time().'.'.$file_extension;
        $path='photos';
        $request->photo->move($path,$file_name);
        // customize the error messages
        $data= request()->all();
         //dd($file_name);
        // store request data in database
        Post::create([
            'title'=>$data['title'],
            'description'=>$data['description'],
            'user_id'=>$data['user'],
            'slug'=>SlugService::createSlug(Post::class,'slug',$data['title']),
            'photo'=>"$file_name",

        ]);
        // redirect to index
        return to_route('posts.index');
    }

    public function show($postId)
    {
        $comments=Comment::all();
$post=Post::find($postId);

        $userid=Auth::id();
        return view('posts.show',['post'=>$post,'comments'=>$comments,'userid'=>$userid]);
    }

    public function edit($postId){
        $users = User::all();
        $post = Post::find($postId);
        return view('posts.edit' , ['post'=>$post, 'users'=> $users]);
    }

    public function update($postId,Request $req){
          $newData=$req->all();
        Post::where('id', $postId)->update([
            'title' => $newData['Post_title'],
            'description' =>$newData['Post_dec'] ,
            'user_id' => $newData['Post_auther'],
        ]);
        return to_route('posts.index');
    }


    public function destroy($postId) {
        Post::where('id', $postId)->delete();
        return redirect()->route('posts.index');
    }


    public function restore($postId) {
        Post::where('id', $postId)->restore();
        return redirect()->route('posts.index');
    }

    public function force_destroy($postId) {
        Post::where('id', $postId)->forceDelete();
        return redirect()->route('posts.index');
    }

    public function checkSlug(Request $request){
        $slug=SlugService::createSlug(Post::class,'slug',$request->title);
        return response()->view("hello");
    }











}
