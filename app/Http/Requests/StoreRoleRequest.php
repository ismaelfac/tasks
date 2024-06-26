<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'display_name' => 'required|string',
            'description' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'A registration_number is required',
            'display_name.required' => 'A vehicle_type is required',
            'description.required' => 'A vehicle_type is required',
        ];
    }
}
