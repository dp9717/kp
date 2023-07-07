<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ModuleRequest extends FormRequest
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
        $data=\App\Models\Module::where('slug',$this->slug)->first();
        $c_id=$data->id ?? '';
        return [
            'name'=>'required|unique:modules,name,'.$c_id,
            //'duration'=>'required',
            //'description'=>'required',
        ];
    }
}
