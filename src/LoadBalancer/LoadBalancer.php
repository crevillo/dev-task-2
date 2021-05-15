<?php

namespace LoadBalancer;

use LoadBalancer\LoadBalancerMethod\Rotation;

class LoadBalancer
{
    /**
     * @var Host[]
     */
    private array $hosts;

    private string $loadBalancerMode;

    /** @var Request[] */
    private array $requestsReceived = [];

    public function __construct(array $hosts, string $loadBalancerMode = 'rotation')
    {
        $this->hosts = $hosts;
        $this->loadBalancerMode = $loadBalancerMode;
    }

    public function handleRequest(Request $request)
    {
        // following code goes against Open Solid Principle
        // a better solution could consist in passing all the rotators to the ctor
        // implemented in this other branch
        if ($this->loadBalancerMode === 'rotation') {
            $loadBalancer = new Rotation();
        } elseif ($this->loadBalancerMode === 'minimumload') {

        }

        $loadBalancer->balance($this, $request);
        $this->requestsReceived[] = $request;
    }

    public function getHosts(): array
    {
        return $this->hosts;
    }

    public function getRequestsReceived(): array
    {
        return $this->requestsReceived;
    }
}
