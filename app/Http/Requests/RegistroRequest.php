<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistroRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string',
            'email' => 'required|string|unique:usuarios|email',
            'password' => 'required|string|min:6',
            'rol' => 'required|numeric|exists:roles,id'
        ];
    }
}

