<?php

namespace App\DTO;

class CollectionDTO extends BaseDTO
{
    private array $collection;

    public function add(BaseDTO $dto)
    {
        $this->collection[] = $dto;
    }

    public function getData(): array
    {
        return $this->collection;
    }
}
