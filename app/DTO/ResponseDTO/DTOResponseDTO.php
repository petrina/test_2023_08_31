<?php

namespace App\DTO\ResponseDTO;

use App\DTO\BaseDTO;

class DTOResponseDTO extends BaseResponseDTO
{

    public function __construct(BaseDTO $baseDTO) {
        $this->success = true;
        $this->data = $baseDTO->getData();
    }
}
