<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
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
        $qualification = array_keys(User::qualification());
        $profession = array_keys(User::profession());
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
            'qualification'=>'required|in:'.implode(',', $qualification),
            'profession'=>'required|in:'.implode(',', $profession)
        ];
    }
}
