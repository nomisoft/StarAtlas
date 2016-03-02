<?php

namespace StarAtlas\Tests;

use StarAtlas\Models\Earth;
use StarAtlas\Models\Moon;
use StarAtlas\Models\Sun;
use StarAtlas\Models\Time;
use StarAtlas\Models\Location;

class MoonTest extends \PHPUnit_Framework_TestCase
{

    private $moon;

    protected function setup()
    {
        $time = new Time("1979-02-26 16:00:00");
        $location = new Location(0, 0);
        $sun = new Sun($time, $location);
        $earth = new Earth($time, $location);
        $this->moon = new Moon($time, $location, $earth, $sun);
    }

    public function testGetAzimuth()
    {
        //$this->assertEquals(0,$this->moon->getAzimuth(),'',1.0);
    }

    public function testGetAltitude()
    {
        //$this->assertEquals(0,$this->moon->getAltitude(),'',1.0);
    }

    public function testGetHourAngle()
    {
        $this->assertEquals(56.25, $this->moon->getHourAngle(), '', 1.0);
    }

    public function testGetOrbitalLongitude()
    {
        $this->assertEquals(335.436, $this->moon->getOrbitalLongitude(), '', 1.0);
    }

    public function testGetMeanAnomaly()
    {
        $this->assertEquals(20.293496, $this->moon->getMeanAnomaly(), '', 1.0);
    }

    public function testGetAscendingNodeLongitude()
    {
        $this->assertEquals(168.225, $this->moon->getAscendingNodeLongitude(), '', 1.0);
    }

    public function testGetEclipticalLatitude()
    {
        $this->assertEquals(0.38, $this->moon->getEclipticalLatitude(), '', 1.0);
    }

    public function testGetEclipticalLongitude()
    {
        $this->assertEquals(336.2, $this->moon->getEclipticalLongitude(), '', 1.0);
    }

    public function testGetPhase()
    {
        $this->assertEquals(336.2, $this->moon->getPhase(), '', 1.0);
    }

    public function testGetRightAscension()
    {
        $this->assertEquals(337.75, $this->moon->getRightAscension(), '', 1.0);
    }

    public function testGetDeclination()
    {
        $this->assertEquals(-8.76, $this->moon->getDeclination(), '', 1.0);
    }
}
