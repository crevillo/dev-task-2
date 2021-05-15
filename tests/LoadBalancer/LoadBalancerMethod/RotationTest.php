<?php

namespace tests\LoadBalancer\LoadBalancerMethod;

use LoadBalancer\Host;
use LoadBalancer\LoadBalancer;
use LoadBalancer\LoadBalancerMethod\Rotation;
use LoadBalancer\Request;
use PHPUnit\Framework\TestCase;

class RotationTest extends TestCase
{
    public function testBalance()
    {
        $host1 = new Host('h1');
        $host2 = new Host('h2');
        $host3 = new Host('h3');

        $loadBalancer = new LoadBalancer([
            $host1,
            $host2,
            $host3,
        ], 'rotation', [new Rotation()]);

        $loadBalancer->handleRequest(new Request('r1'));
        $loadBalancer->handleRequest(new Request('r2'));
        $loadBalancer->handleRequest(new Request('r3'));
        $loadBalancer->handleRequest(new Request('r4'));
        $loadBalancer->handleRequest(new Request('r5'));

        $this->assertEquals(2, count($host1->getHandledRequests()));
        $this->assertEquals(2, count($host2->getHandledRequests()));
        $this->assertEquals(1, count($host3->getHandledRequests()));

        $this->assertEquals('r1', $host1->getHandledRequests()[0]->getId());
        $this->assertEquals('r4', $host1->getHandledRequests()[1]->getId());
        $this->assertEquals('r5', $host2->getHandledRequests()[1]->getId());
    }
}
