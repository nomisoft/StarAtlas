<?php

namespace StarAtlas\Tests;

use StarAtlas\Models\Star;
use StarAtlas\Models\Time;
use StarAtlas\Models\Location;

class StarTest extends \PHPUnit_Framework_TestCase
{

    private $star;

    protected function setup()
    {
        $time = new Time("1987-04-10 19:21:00");
        $location = new Location(51.666666, 0);
        $this->star = new Star($time, $location);
        $this->star->setCatalogueNumber(32349);
        $this->star->setName('Sirius');
        $this->star->setRightAscension(101.288541);
        $this->star->setDeclination(-16.713143);
        $this->star->setApparentMagnitude(-1.44);
        $this->star->setBv(0);
    }

    public function testGetCatalogueNumber()
    {
        $this->assertEquals(32349, $this->star->getCatalogueNumber());
    }

    public function testGetName()
    {
        $this->assertEquals("Sirius", $this->star->getName());
    }

    public function testGetAzimuth()
    {
        $this->assertEquals(207.75, $this->star->getAzimuth(), '', 0.5);
    }

    public function testGetAltitude()
    {
        $this->assertEquals(17.68, $this->star->getAltitude(), '', 0.5);
    }

    public function testGetHourAngle()
    {
        $this->assertEquals(27.25, $this->star->getHourAngle(), '', 0.5);
    }
}
