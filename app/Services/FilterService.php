<?php

namespace App\Services;

abstract class FilterService
{
    protected array $data;

    public function __construct(array $data = [])
    {
        $this->setData($data);
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }
}
