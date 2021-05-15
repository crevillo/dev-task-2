<?php

namespace LoadBalancer\LoadBalancerMethod;

use LoadBalancer\Host;
use LoadBalancer\LoadBalancer as LoadBalancerEntity;
use LoadBalancer\Request;

class MinimumLoad implements LoadBalancerMethod
{
    const THRESHOLD = 0.75;

    public function balance(LoadBalancerEntity $balancer, Request $request): void
    {
        $host = $this->determineHostWithLessLoad($balancer->getHosts());
        $host->handleRequest($request);
    }

    private function determineHostWithLessLoad(array $hosts): Host
    {
        $hostsNotOverLoaded = array_values(
            array_filter($hosts, function(Host $host) {
                return $host->getLoad() < self::THRESHOLD;
            })
        );

        if (!empty($hostsNotOverLoaded)) {
            return $hostsNotOverLoaded[0];
        }

        // all has load over the threshold. Get the one with the minium by sorting.
        usort($hosts, fn(Host $host1, Host $host2) => $host1->getLoad() <=> $host2->getLoad());
        return $hosts[0];
    }

    public function getIdentifier(): string
    {
        return 'minimumLoad';
    }
}
