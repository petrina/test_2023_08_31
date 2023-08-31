<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'token' => 'required|string',
        ];
    }
}
