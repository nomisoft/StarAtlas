<?php

namespace StarAtlas\Tests;

use StarAtlas\Models\Time;
use StarAtlas\Models\Location;

class CelestialObjectTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider providerRanges
     */
    public function testBringWithinRange($num, $range, $expectedResult)
    {
        $time = new Time();
        $location = new Location(0, 0);
        $celestialObject = $this->getMockForAbstractClass('StarAtlas\Models\CelestialObject', array($time, $location));

        $reflection = new \ReflectionClass(get_class($celestialObject));
        $method = $reflection->getMethod('bringWithinRange');
        $method->setAccessible(true);
        $result = $method->invokeArgs($celestialObject, array($num, $range));

        $this->assertEquals($expectedResult, $result, '', 1.0);
    }

    public function providerRanges()
    {
        return array(
            array(400, 360, 40),
            array(800, 360, 80),
            array(-40, 360, 320),
            array(0, 360, 0),
            array(140, 100, 40),
        );
    }
}
