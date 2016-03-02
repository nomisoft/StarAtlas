<?php

namespace StarAtlas\Tests;

use StarAtlas\Models\Location;

class LocationTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider providerValidCoordinates
     */
    public function testConstructor($latitude, $longitude)
    {
        $location = new Location($latitude, $longitude);
        $this->assertEquals($latitude, $location->getLatitude(), '', 0.1);
        $this->assertEquals($longitude, $location->getLongitude(), '', 0.1);
    }

    /**
     * @dataProvider providerValidCoordinates
     */
    public function testSetLatitudeLongitude($latitude, $longitude)
    {
        $location = new Location(0, 0);
        $location->setLatitude($latitude);
        $location->setLongitude($longitude);
        $this->assertEquals($latitude, $location->getLatitude(), '', 0.1);
        $this->assertEquals($longitude, $location->getLongitude(), '', 0.1);
    }

    public function providerValidCoordinates()
    {
        return array(
            array(0, 0),
            array(36, 12),
            array(-19, 12),
            array(0, -3),
        );
    }

    /**
     * @dataProvider providerTestOutOfRangeCoordinates
     */
    public function testOutOfRangeCoordinates($latitude, $longitude, $expectedLatitude, $expectedLongitude)
    {
        $location = new Location($latitude, $longitude);
        $this->assertEquals($expectedLatitude, $location->getLatitude(), '', 0.1);
        $this->assertEquals($expectedLongitude, $location->getLongitude(), '', 0.1);
    }

    public function providerTestOutOfRangeCoordinates()
    {
        return array(
            array(100, 0, 10, 0),
            array(-100, 0, -10, 0),
            array(0, 190, 0, 10),
            array(0, -190, 0, -10),
            array(0, -400, 0, -40)
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider providerInvalidCoordinates
     */
    public function testInvalidCoordinates($latitude, $longitude)
    {
        $location = new Location($latitude, $longitude);
    }

    public function providerInvalidCoordinates()
    {
        return array(
            array('A', null),
            array(null, []),
        );
    }
}
