<?php

namespace LoadBalancer;

use LoadBalancer\LoadBalancerMethod\LoadBalancerMethod;
use LoadBalancer\LoadBalancerMethod\MinimumLoad;
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

    /** @var LoadBalancerMethod[] */
    private array $availableMethods = [];

    public function __construct(array $hosts, string $loadBalancerMode = 'rotation', array $availableMethods = [])
    {
        $this->validateHostsLists($hosts);
        $this->hosts = $hosts;
        $this->loadBalancerMode = $loadBalancerMode;

        $this->availableMethods = $this->buildAvailableMethodsList($availableMethods);
        $this->validateLoadBalancerMode($loadBalancerMode);
    }

    /**
     * @param Request $request
     */
    public function handleRequest(Request $request)
    {
        $loadBalancer = $this->availableMethods[$this->loadBalancerMode];

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

    private function validateLoadBalancerMode($loadBalancerMode)
    {
        if (!in_array($loadBalancerMode, array_keys($this->availableMethods))) {
            throw new InvalidMethodException('Invalid load balancer method passed');
        }
    }

    private function buildAvailableMethodsList(array $loadBalancerMethods)
    {
        $keys = array_map(function(LoadBalancerMethod $lbm) {
            return $lbm->getIdentifier();
        }, $loadBalancerMethods);

        $values = array_map(function(LoadBalancerMethod $lbm) {
            return $lbm;
        }, $loadBalancerMethods);

        return array_combine($keys, $values);
    }
}
