<?php

namespace LoadBalancer;

class Host
{
    private float $load = 0;

    private int $handledRequests = 0;

    private string $id;

    public function __construct(string $id, float $load = 0)
    {
        $this->id = $id;
        $this->load = $load;
    }

    public function getLoad(): float
    {
        return $this->load;
    }

    public function handleRequest(Request $request)
    {
        $this->handledRequests++;
    }

    public function getHandledRequests(): int
    {
        return $this->handledRequests;
    }
}
