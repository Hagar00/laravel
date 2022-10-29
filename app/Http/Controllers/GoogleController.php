<?php

namespace App\Http\Controllers;
use App\Http\Requests\StorePostRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function auth() {
        return Socialite::driver('google')->redirect();
    }

    public function callback() {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();

            if($finduser){
                Auth::login($finduser);
                return redirect('/posts');
            }else{
                $validator = Validator::make(["email" => $user->email], [
                    'email' => ['required', "unique:users"]
                ]);

                if ($validator->fails()) {
                    return redirect('/login')
                        ->withErrors($validator);
                }
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                ]);

                Auth::login($newUser);

                return redirect('/posts');;

            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
