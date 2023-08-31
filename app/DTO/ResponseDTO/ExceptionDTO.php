<?php

namespace App\DTO\ResponseDTO;

class ExceptionDTO extends BaseResponseDTO
{

    public function __construct(string $message) {
        $this->success = false;
        $this->message = $message;
    }
}
