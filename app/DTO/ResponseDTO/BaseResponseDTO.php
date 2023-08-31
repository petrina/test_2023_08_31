<?php

namespace App\DTO\ResponseDTO;

class BaseResponseDTO
{

    protected bool $success = true;
    protected string $message = '';
    protected mixed $data;

    public function getResponse(): array
    {
        $response = [
            'success' => $this->success
        ];

        if ($this->success) {
            $response['data'] = $this->data;
        } else {
            $response['message'] = $this->message;
        }

        return $response;
    }
}
