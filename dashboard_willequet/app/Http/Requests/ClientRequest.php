<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'color' => ['required', 'max:8'],
            'name' => ['required', 'max:255'],
            'address' => ['max:255'],
            'email' => ['nullable','email', 'max:255'],
            'averageAmount' => ['max:255'],
            'telephone' => ['max:255'],
            'category' => ['max:100']
        ];
    }
}
