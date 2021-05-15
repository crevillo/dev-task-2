<?php
namespace tests\LoadBalancer;

use LoadBalancer\DuplicateHostIdentifierException;
use LoadBalancer\Host;
use LoadBalancer\InvalidMethodException;
use LoadBalancer\LoadBalancer;
use PHPUnit\Framework\TestCase;

class LoadBalancerTest extends TestCase
{
    /**
     * @dataProvider listProvider
     */
    public function testValidatesTheListOfHostsPassed($list)
    {
        $this->expectException(DuplicateHostIdentifierException::class);

        (new LoadBalancer($list));
    }

    public function listProvider()
    {
        return [
            [[new Host('h1'), new Host('h1')]],
            [[new Host('h1'), new Host('h2'), new Host('h3'), new Host('h1')]]
        ];
    }

    public function testValidateLoadBalancerMethod()
    {
        $this->expectException(InvalidMethodException::class);

        (new LoadBalancer([new Host('h1')], 'a_method'));
    }
}
