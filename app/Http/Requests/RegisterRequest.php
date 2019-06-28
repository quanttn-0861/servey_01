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
            'name' => 'required|max:30|regex:/^[A-Za-z\x{00C0}-\x{00FF}][A-Za-z\x{00C0}-\x{00FF}\'\-]+([\ A-Za-z\x{00C0}-\x{00FF}][A-Za-z\x{00C0}-\x{00FF}\'\-]+)*/u',
            'email' => 'required|max:255|unique:users|regex:/^[a-zA-Z0-9]([\.-_]?[a-zA-Z0-9])*@[a-zA-Z0-9]([\.-]?[a-zA-Z0-9-_])*(\.[a-zA-Z0-9]{2,4})+$/',
            'password' => 'required|min:6|regex:/^\S*(?=\S*[a-zA-Z])(?=\S*[\W])(?=\S*[\d])\S*$/|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.regex' => trans('validation.msg.name'),
            'password.regex' => trans('validation.password_without_spaces_and_require_letter_number_special_character'),
        ];
    }
}
