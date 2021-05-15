<?php

namespace tests\LoadBalancer\LoadBalancerMethod;

use LoadBalancer\Host;
use LoadBalancer\LoadBalancer;
use LoadBalancer\Request;
use PHPUnit\Framework\TestCase;

class MinimumLoadTest extends TestCase
{
    public function hostsListProvider()
    {
        // list of hosts and id of the host that should be returned
        return [
            [
                [new Host('h1', 0.8), new Host('h2', 0.6), new Host('h3', 0.8), new Host('h4', 0.4)],
                1,
            ],
            [
                [new Host('h1', 0.9), new Host('h2', 0.9), new Host('h3', 0.8), new Host('h4', 0.9)],
                2
            ]
        ];
    }

    /**
     * @dataProvider hostsListProvider
     */
    public function testMiminumLoadBalance($hostsList, $hostIndex)
    {
        $loadBalancer = new LoadBalancer($hostsList, 'minimumLoad');
        $loadBalancer->handleRequest(new Request('r1'));
        $this->assertCount(1, $loadBalancer->getHosts()[$hostIndex]->getHandledRequests());
    }
}
