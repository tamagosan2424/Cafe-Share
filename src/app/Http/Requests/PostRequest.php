<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'          =>'required|string|max:255',
            'address'       =>'required|string|max:255',
            'phone_number'  =>'nullable|string|max:20',
            'opening_at'    =>'nullable|date_format:H:i',
            'closing_at'    =>'nullable|date_format:H:i',
            'description'   =>'nullable|string'
        ];
    }
}
