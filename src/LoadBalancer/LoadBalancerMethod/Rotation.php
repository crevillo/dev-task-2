<?php

namespace LoadBalancer\LoadBalancerMethod;

use LoadBalancer\LoadBalancer;
use LoadBalancer\LoadBalancerMethod\LoadBalancer as LoadBalancerMethod;

class Rotation implements LoadBalancerMethod
{
    public function balance(LoadBalancer $balancer)
    {
    }
}
