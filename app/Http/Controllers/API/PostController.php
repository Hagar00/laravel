<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;

class PostController extends Controller
{
      public function index(){
           $posts = Post::all();
           //return with PostResource class
          return PostResource::collection($posts);
      }

      public function show($id){
          $posts=Post::find($id);

          return new PostResource($posts);

          // make the key of responce the same
//          return [
//              'title_2'=>$posts->title,
//              'id'=>$posts->id,
//              'description'=>$posts->description,
//              'creator'=>$posts->user->name,
//          ];
      }

      public function store(StorePostRequest $request){
          $data= request()->all();

        $post=  Post::create([
              'title'=>$data['title'],
              'description'=>$data['description'],
              'user_id'=>$data['user'],
              'slug'=>SlugService::createSlug(Post::class,'slug',$data['title']),
          ]);
        return new PostResource($post);

      }




}




