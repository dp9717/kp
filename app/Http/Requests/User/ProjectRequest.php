<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'name'=>'required',
            'funded_by'=>'required|in:'.implode(',', array_keys(\App\Models\Project::fundedby())),
            'mou_signed'=>'required|in:yes,no',
            'start_date'=>'required',
            'end_date'=>'required',
            'centre[].*'=>'required|exists:centre_creations,slug',
            'pjManager[].*'=>'required|exists:users,slug',
            'pjStateHead[].*'=>'required|exists:users,slug',
            'partner[].*'=>'required|exists:partners,slug',
            'upload_file[].*'=>'mimes:jpeg,png,jpg,gif,svg,doc,csv,xlsx,xls,docx,ppt,pdf|max:5120'
        ];
    }
} 
