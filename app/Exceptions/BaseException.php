<?php

namespace App\Exceptions;

use App\DTO\ResponseDTO\ExceptionDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class BaseException extends Exception
{

    protected function getResponse(int $status): JsonResponse
    {
        return response()
            ->json((new ExceptionDTO($this->getMessage()))->getResponse(), $status)
            ->header('Content-Type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*');
    }
}
