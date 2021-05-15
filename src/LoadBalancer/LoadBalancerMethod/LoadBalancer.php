<?php

namespace LoadBalancer\LoadBalancerMethod;
use LoadBalancer\LoadBalancer as LoadBalancerEntity;

interface LoadBalancer
{
    public function balance(LoadBalancerEntity $balancer);
}
