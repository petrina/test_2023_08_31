<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSellRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'count' => 'required|numeric',
            'price' => 'required|numeric',
            'currency' => 'required|string',
        ];
    }
}
