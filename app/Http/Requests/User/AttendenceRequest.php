<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class AttendenceRequest extends FormRequest
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
        $b = \App\Models\Batch::where(['slug'=>$this->batch])->first();
        $start_date =(isset($b->start_date) && $b->start_date) ? $b->start_date : ''; 
        $end_date =(isset($b->end_date) && $b->end_date) ? $b->end_date : ''; 
        return [
            'batch'=>'required|exists:batches,slug',
            'attendence_date'=>'required|date|after_or_equal:'.$b->start_date.'|before_or_equal:'.$b->end_date,
        ];
    }
}
