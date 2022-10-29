<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

                'title'=>['required','min:3','unique:posts,title'],
                'description'=>['required'],
                 'slug'=>[

                     'alpha_dash',
                     'unique:posts',
                 ]


            // customize the error messages



        ];
    }

    // function to customize the error messages
    public function messages(){
        return [
            'title.required'=>'title is required and must be more than 3 characters',
        ];
    }
}
