<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\PostController;
use \App\Http\Controllers\CommentController;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/**
 *  to the method get we send two params the uri and array->that has two elements the first is the controller class
 * and the second is the  public method inside the controller class that will execute
 * //important-> uri with param should be in the bottom to avoid conflict
 */
//Route::get('/test', [TestController::class,'testAction']);
//Route::get('/name', [TestController::class,'tableName']);

Route::middleware('auth')->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');//->middleware('auth');
    Route::get('/posts/create/', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/page/{page}', [PostController::class, 'paginate'])->name('posts.paginate');
    Route::get('/posts/{post}/edit',[PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'] )->name('posts.update');
    Route::delete('/posts/{post}/delete', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::get('/posts/{post}/restore', [PostController::class, 'restore'])->name('posts.restore');
    Route::delete('/posts/{post}/force_delete', [PostController::class, 'force_destroy'])->name('posts.force_destroy');
    Route::get('/posts/comment/{id}',[CommentController::class, 'comment'])->name('posts.com');
    Route::post('/posts/comment',[CommentController::class, 'storeComment'])->name('comments.store');
    Route::get('/posts/comment_/{comment}', [CommentController::class, 'edit'] )->name('comments.edit');
    Route::put('/posts/comment_/{comment}', [CommentController::class, 'update'] )->name('comments.update');
    Route::delete('/posts/comments/{comment}/delete', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::get('/posts/comments/{post}/restore', [CommentController::class, 'restore'])->name('comments.restore');
    Route::delete('/posts/comments/{post}/force_delete', [CommentController::class, 'force_destroy'])->name('comments.force_destroy');
    Route::get('/posts/checkSlug',[PostController::class,'checkSlug'])->name('posts.checkSlug');
});



Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


/////// third party auth using socialite


Route::get('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
})->name('login_with_github');

Route::get('/auth/callback', function () {
    //$user = Socialite::driver('github')->user();
    //dd($user);
    $githubUser = Socialite::driver('github')->user();

    $user = User::where('github_id', $githubUser->id)->first();

    if ($user) {
        $user->update([
            'github_token' => $githubUser->token,
            'github_refresh_token' => $githubUser->refreshToken,
        ]);
    } else {
        $user = User::create([
            'name' => $githubUser->name,
            'email' => $githubUser->email,
            'github_id' => $githubUser->id,
            'github_token' => $githubUser->token,
            'github_refresh_token' => $githubUser->refreshToken,
        ]);
    }

    Auth::login($user);

    return redirect('/posts');

});


// google auth
Route::get('auth/google', [GoogleController::class, 'auth'])->name('login.google');
Route::get('auth/google/callback', [GoogleController::class, 'callback']);



