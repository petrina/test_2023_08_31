<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotFoundException extends BaseException
{
    public function render(Request $request): JsonResponse
    {
        return $this->getResponse(404);
    }
}
