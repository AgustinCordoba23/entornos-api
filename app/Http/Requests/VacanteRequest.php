<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VacanteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'fecha_fin' => 'required|date_format:Y-m-d|',
        ];
    }
}


