<?php

namespace StarAtlas\Tests;

use StarAtlas\Models\Time;
use StarAtlas\Models\Location;
use StarAtlas\Models\Earth;
use StarAtlas\Models\Planet;

class PlanetTest extends \PHPUnit_Framework_TestCase
{

    private $planet;

    protected function setup()
    {
        $time = new Time("1988-11-22 0:00:00");
        $location = new Location(0, 0);
        $earth = new Earth($time, $location);
        $this->planet = new Planet($time, $location, $earth);
        $this->planet->setId(1);
        $this->planet->setName('Mercury');
        $this->planet->setPeriod(0.240852);
        $this->planet->setEpochLongitude(60.750646);
        $this->planet->setPerihelionLongitude(77.299833);
        $this->planet->setEccentricity(0.205633);
        $this->planet->setSemiMajorAxis(0.387099);
        $this->planet->setInclination(7.004540);
        $this->planet->setAscendingNodeLongitude(48.212740);
        $this->planet->setAngularDiameter1Au(6.74);
        $this->planet->setMagnitude1au(-0.42);
    }

    public function testGetAzimuth()
    {
        $this->assertEquals(15.4, $this->planet->getAzimuth(), '', 1.5);
    }

    public function testGetAltitude()
    {
        $this->assertEquals(-56.483, $this->planet->getAltitude(), '', 0.5);
    }

    public function testGetHourAngle()
    {
        $this->assertEquals(-171, $this->planet->getHourAngle(), '', 0.5);
    }

    public function testGetMeanAnomaly()
    {
        $this->assertEquals(130.132, $this->planet->getMeanAnomaly(), '', 0.1);
    }

    public function testGetHeliocentricLongitude()
    {
        $this->assertEquals(225.447, $this->planet->getHeliocentricLongitude(), '', 0.1);
    }

    public function testGetVariation()
    {
        $this->assertEquals(148.147, $this->planet->getVariation(), '', 0.1);
    }

    public function testGetSunDistance()
    {
        $this->assertEquals(0.4663, $this->planet->getSunDistance(), '', 0.5);
    }

    public function testGetHeliocentricLatitude()
    {
        $this->assertEquals(0.337048, $this->planet->getHeliocentricLatitude(), '', 0.5);
    }

    public function testGetProjectedHeliocentricLongitude()
    {
        $this->assertEquals(225.468423, $this->planet->getProjectedHeliocentricLongitude(), '', 0.5);
    }

    public function testGetProjectedRadiusVector()
    {
        $this->assertEquals(0.449182, $this->planet->getProjectedRadiusVector(), '', 0.5);
    }

    public function testGetEclipticalLatitude()
    {
        $this->assertEquals(0.106, $this->planet->getEclipticalLatitude(), '', 0.5);
    }

    public function testGetEclipticalLongitude()
    {
        $this->assertEquals(235.433, $this->planet->getEclipticalLongitude(), '', 0.5);
    }

    public function testGetEarthDistance()
    {
        $this->assertEquals(1.4119, $this->planet->getEarthDistance(), '', 0.5);
    }

    public function testGetAngularSeparation()
    {
    }

    public function testGetPhase()
    {
    }

    public function testGetApparentMagnitude()
    {
    }

    public function testGetLightTime()
    {
    }

    public function testGetDeclination()
    {
        $this->assertEquals(-18.73, $this->planet->getDeclination(), '', 0.5);
    }

    public function testGetRightAscension()
    {
        $this->assertEquals(232.425, $this->planet->getRightAscension(), '', 1.0);
    }

    public function testJsonSerialize()
    {
        $this->assertJson(json_encode($this->planet->jsonSerialize()));
    }
}
