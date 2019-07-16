<?php

namespace ThoroughPHP\Espionage\Tests;

use PHPUnit\Framework\TestCase;
use ThoroughPHP\Espionage\Spy;

final class SpyTest extends TestCase
{
    public function testSpyOn(): void
    {
        $spy = new Spy();

        $object = new StubObject();
        /** @var StubObject $objectUnderSurveillance */
        $objectUnderSurveillance = $spy->spyOn($object);
        $objectUnderSurveillance->method();

        $protocol = $spy->getProtocol();

        $this->assertArrayHasKey($hash = spl_object_hash($object), $protocol);
        $this->assertEquals('method', $protocol[$hash]['calls'][0]['method']);
    }
}