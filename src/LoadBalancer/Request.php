<?php

namespace LoadBalancer;

class Request
{
    private string $id;

    public function __construct(string $id)
    {
        if (empty($id)) {
            throw new BadRequestIdentifierException("cannot be empty");
        }

        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
