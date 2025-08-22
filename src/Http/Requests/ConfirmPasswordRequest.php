<?php

namespace Dotclang\AuthPackage\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmPasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'password' => 'required|string',
        ];
    }
}
