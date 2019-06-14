<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class UpdateSurveyRequest extends FormRequest
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
            'title' => 'required|max:255',
            'start_time' => 'date',
            'end_time' => 'date|after:start_time',
            'option' => 'between:0,1',
            'delete.sections.*' => 'integer',
            'delete.questions.*' => 'integer',
            'delete.answers.*' => 'integer',
        ];
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    protected function validationData()
    {
        return $this->json()->all();
    }
}
