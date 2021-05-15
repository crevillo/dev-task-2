<?php

namespace LoadBalancer\LoadBalancerMethod;

use LoadBalancer\LoadBalancer;
use LoadBalancer\Request;

class Rotation implements LoadBalancerMethod
{
    /**
     * We can now how many requests the balancer has received.
     * Is a matter to use mod operator to determine which host should receive the request
     */
    public function balance(LoadBalancer $balancer, Request $request): void
    {
        $hosts = $balancer->getHosts();

        $hostIndex = $balancer->getRequestsReceived() % count($hosts);

        $hosts[$hostIndex]->handleRequest($request);
    }
}
