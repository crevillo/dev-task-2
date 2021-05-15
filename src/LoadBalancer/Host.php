<?php

namespace LoadBalancer;

class Host
{
    private float $load = 0;

    /** @var Request[]  */
    private array $handledRequests = [];

    private string $id;

    public function __construct(string $id, float $load = 0)
    {
        if (empty($id)) {
            throw new BadHostIdentifierException('Host id cannot be empty');
        }

        $this->id = $id;
        $this->load = $load;
    }

    public function getLoad(): float
    {
        return $this->load;
    }

    public function handleRequest(Request $request)
    {
        $this->handledRequests[] = $request;
    }

    public function getHandledRequests(): array
    {
        return $this->handledRequests;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
