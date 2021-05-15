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
        $this->validateHostsLists($hosts);
        $this->hosts = $hosts;
        $this->loadBalancerMode = $loadBalancerMode;
    }

    /**
     * @param Request $request
     */
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

    /**
     * @return array|Host[]
     */
    public function getHosts(): array
    {
        return $this->hosts;
    }

    /**
     * @return Request[]
     */
    public function getRequestsReceived(): array
    {
        return $this->requestsReceived;
    }

    private function validateHostsLists(array $hosts)
    {
        $hostIds = array_map(function(Host $host) {
            return $host->getId();
        }, $hosts);

        // if the count of unique identifiers is less than the number of hosts passed means that at least one of them is
        // duped;

        if (count(array_unique($hostIds)) < count($hosts)) {
            throw new DuplicateHostIdentifierException('At least one of the hosts identifiers is duplicated');
        }
    }
}
