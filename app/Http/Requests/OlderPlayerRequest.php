<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OlderPlayerRequest extends FormRequest
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
            'email' => ['required', 'email'],
            'whatsapp' => ['required'],
            'langue' => ['min:5', 'required'],
            'name' => ['min:3', 'required'],
            'photo' => ['required', 'image']
        ];
    }
}
