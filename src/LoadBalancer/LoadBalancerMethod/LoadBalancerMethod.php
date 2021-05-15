<?php

namespace LoadBalancer\LoadBalancerMethod;
use LoadBalancer\Host;
use LoadBalancer\LoadBalancer as LoadBalancerEntity;
use LoadBalancer\Request;

interface LoadBalancerMethod
{
    public function balance(LoadBalancerEntity $balancer, Request $request): void;
}
