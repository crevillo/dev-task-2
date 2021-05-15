<?php

namespace tests\LoadBalancer;

use LoadBalancer\BadRequestIdentifierException;
use LoadBalancer\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testInitializeRequestWithLoadIncrement()
    {
        $request = new Request("r1");
        $this->assertEquals("r1", $request->getId());
    }

    public function testThrowExceptionIfBadId()
    {
        $this->expectException(BadRequestIdentifierException::class);
        $request = new Request('');
    }
}
