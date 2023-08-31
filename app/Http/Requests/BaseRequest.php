<?php

namespace App\Http\Requests;

use App\Exceptions\BadRequestException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @throws BadRequestException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new BadRequestException('Incorrect request');
    }
}
