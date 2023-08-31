<?php

namespace App\DTO\ResponseDTO;

use App\DTO\BaseDTO;

class CollectionResponseDTO extends BaseResponseDTO
{

    public function __construct(BaseDTO $baseDTO) {
        $this->success = true;
//        $this->data = $baseDTO->getData();
        /** @var BaseDTO $dto */
        foreach ($baseDTO->getData() as $dto) {
            $this->data[] = $dto->getData();
        }
    }
}
