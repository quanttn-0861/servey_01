<?php

namespace App\Http\Requests\Survey;

use Illuminate\Foundation\Http\FormRequest;

class ChangePassWordRequest extends FormRequest
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
            'oldpassword' => 'required|min:6',
            'newpassword' => 'required|min:6|regex:/^\S*(?=\S*[a-zA-Z])(?=\S*[\W])(?=\S*[\d])\S*$/',
            'retypepassword' => 'required|min:6|same:newpassword',
        ];
    }

    public function messages()
    {
        return [
            'newpassword.regex' => trans('validation.password_without_spaces_and_require_letter_number_special_character'),
        ];
    }
}
