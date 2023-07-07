<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'role'=>'required|exists:roles,slug',
            'name'=>'required',
            'contact'=>'required',
            'email'=>'required|email',
            'address'=>'required',
            'office_no'=>'required',
            'office_email'=>'required',
            'designation'=>'required',
            'additional_information'=>'',
            'pincode'=>'required|exists:pincodes,slug',
        ];
    }
}





