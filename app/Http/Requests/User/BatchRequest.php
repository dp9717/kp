<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class BatchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'project'=>'required|exists:projects,slug',
            'start_date'=>'required|date',
            'end_date'=>'required|date|after_or_equal:start_date',
            'start_time'=>'required',
            'end_time'=>'required',
            'module'=>'required|exists:modules,slug',
            'trainer'=>'required|exists:users,slug',
            'location'=>'required|exists:centre_creations,slug',
            'state_co_ordinator'=>'required|exists:users,slug',
            'upload_file[].*'=>'mimes:jpeg,png,jpg,gif,svg,doc,csv,xlsx,xls,docx,ppt,pdf|max:5120',

            'name[].*'=>'required',
        ];
    }
}
