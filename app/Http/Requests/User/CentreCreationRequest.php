<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CentreCreationRequest extends FormRequest
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
            'contact'=>'required',
            'email'=>'required|email',
            'centre_head'=>'required|exists:users,slug',
            'address'=>'required',
            'pincode'=>'required|exists:pincodes,slug',
            'additional_information'=>'',
            'upload_file[].*'=>'mimes:jpeg,png,jpg,gif,svg,doc,csv,xlsx,xls,docx,ppt,pdf|max:5120'
        ]; 
    }
}
