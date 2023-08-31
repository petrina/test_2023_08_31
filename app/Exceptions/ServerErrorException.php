<?php

namespace App\Exceptions;

use App\DTO\ResponseDTO\ExceptionDTO;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServerErrorException extends BaseException
{
    public function render(Request $request): JsonResponse
    {
        return $this->getResponse(500);
    }
}
