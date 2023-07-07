<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CertificateRequest extends FormRequest
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
        $newDate = \Carbon\Carbon::now()->addDay(8)->format('Y-m-d');
        $curDate = \Carbon\Carbon::now()->format('Y-m-d');
        $validDate = $slug = '';
        if($this->certificate_validity == 1) {
            $validDate = 'required|date|after_or_equal:'.$curDate;
        }
        $logo2_file = 'required|mimes:jpeg,png,jpg,gif,svg|max:5120';
        $signature2 = 'required|mimes:jpeg,png,jpg,gif,svg|max:5120';
        if($this->slug) {
            $logo2_file = 'mimes:jpeg,png,jpg,gif,svg|max:5120';
            $signature2 = 'mimes:jpeg,png,jpg,gif,svg|max:5120';
        }
        return [
            'batch'=>'required|exists:batches,slug',
            'certificate_heading'=>'required|integer|in:'.implode(',', array_keys(\App\Models\Certificate::certificateHeadings())),
            'logo1_file'=>'mimes:jpeg,png,jpg,gif,svg|max:5120',
            'logo2_file'=>$logo2_file,
            'logo3_file'=>'mimes:jpeg,png,jpg,gif,svg|max:5120',
            'issued_on'=>'required|date|after_or_equal:'.$curDate,
            'certificate_validity'=>'required|integer|in:'.implode(',', array_keys(\App\Models\Certificate::certificateValidities())),
            'validity_date'=>$validDate,
            'name.2'=>'required',
            'designation.2'=>'required',
            'company.2'=>'required',
            'signature.2'=>$signature2,
            'hard_copy'=>'required|in:'.implode(',', array_keys(\App\Models\Certificate::hardCopy())),
            'needed_by'=>'required|date|after_or_equal:'.$newDate,
            'vendor' => 'required|exists:vendors,slug|in:'.implode(',', array_keys(\App\Models\Certificate::printingVendor()->toArray())),
        ];
    }

    public function messages()
    {
        return [
            'name.2.required' => 'signature name 3 is required.',
            'designation.2.required' => 'signature designation 3 is required.',
            'company.2.required' => 'signature company 3 is required.',
            'signature.2.required' => 'signature signature 3 is required.',
        ];
    }
}
