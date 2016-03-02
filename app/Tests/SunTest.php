<?php

namespace StarAtlas\Tests;

use StarAtlas\Models\Sun;
use StarAtlas\Models\Time;
use StarAtlas\Models\Location;

class SunTest extends \PHPUnit_Framework_TestCase
{

    private $sun;

    protected function setup()
    {
        $time = new Time("1980-07-27 12:00:00");
        $location = new Location(51.666666, 0);
        $this->sun = new Sun($time, $location);
    }

    public function testGetHourAngle()
    {
        $this->assertEquals(358.26, $this->sun->getHourAngle(), '', 1.0);
    }

    public function testGetAltitude()
    {
        $this->assertEquals(57.36, $this->sun->getAltitude(), '', 1.0);
    }

    public function testGetAzimuth()
    {
        $this->assertEquals(177.9, $this->sun->getAzimuth(), '', 1.0);
    }

    public function testGetMeanAnomaly()
    {
        $this->assertEquals(202.065, $this->sun->getMeanAnomaly(), '', 1.0);
    }

    public function testGetTrueAnomaly()
    {
        $this->assertEquals(201.345, $this->sun->getTrueAnomaly(), '', 1.0);
    }

    public function testGetEclipticalLongitude()
    {
        $this->assertEquals(124.114, $this->sun->getEclipticalLongitude(), '', 1.0);
    }

    public function testGetRightAscension()
    {
        $this->assertEquals(126.925, $this->sun->getRightAscension(), '', 1.0);
    }

    public function testGetDeclination()
    {
        $this->assertEquals(19.230, $this->sun->getDeclination(), '', 1.0);
    }
}
