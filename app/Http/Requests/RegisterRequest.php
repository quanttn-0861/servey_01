<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|max:20',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed|regex:/^\S*(?=\S*[a-zA-Z])(?=\S*[\W])(?=\S*[\d])\S*$/',
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => trans('validation.password_without_spaces_and_require_letter_number_special_character'),
        ];
    }
}
