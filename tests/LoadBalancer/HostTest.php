<?php

namespace tests\LoadBalancer;

use LoadBalancer\Host;
use LoadBalancer\Request;
use PHPUnit\Framework\TestCase;

class HostTest extends TestCase
{
    public function testGetLoadAfterInitializing()
    {
        $this->assertEquals(0.3, (new Host('h2', 0.3))->getLoad());
    }

    public function testReturnHandledRequests()
    {
        $host = new Host('h1');

        $request1 = new Request("r1");
        $request2 = new Request("r2");
        $request3 = new Request("r3");

        $host->handleRequest($request3);
        $host->handleRequest($request1);
        $host->handleRequest($request2);

        $handledRequests = $host->getHandledRequests();
        $this->assertEquals(3, $handledRequests);
    }
}
