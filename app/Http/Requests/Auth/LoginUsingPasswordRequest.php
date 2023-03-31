<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\FormRequest;

class LoginUsingPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => 'required|email',
            'password' => 'required|min:8',
        ];
    }
}
