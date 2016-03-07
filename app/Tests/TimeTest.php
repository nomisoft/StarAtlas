<?php

namespace StarAtlas\Tests;

use StarAtlas\Models\Location;
use StarAtlas\Models\Time;

class TimeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider providerTestGetYear
     */
    public function testGetYear($datetime, $expected)
    {
        $time = new Time($datetime);
        $this->assertEquals($expected, $time->getYear());
    }

    public function providerTestGetYear()
    {
        return array(
            array("2016-03-01 15:38:14", 2016),
            array("1987-04-10 00:00:00", 1987),
            array("1600-12-31 00:00:00", 1600),
            array("837-04-10 12:00:00",  837),
            array("-1001-08-17 21:36:00", -1001),
            array("-4712-01-01 12:00:00", -4712)
        );
    }

    /**
     * @dataProvider providerTestSetYear
     */
    public function testSetYear($year)
    {
        $time = new Time();
        $time->setYear($year);
        $this->assertEquals($year, $time->getYear());
    }

    public function providerTestSetYear()
    {
        return array(
            array(2016),
            array(1987),
            array(1600),
            array(837),
            array(-1001),
            array(-4712)
        );
    }

    /**
     * @dataProvider providerTestGetJulianTime
     */
    public function testGetJulianTime($datetime, $expected)
    {
        $time = new Time($datetime);
        $this->assertEquals($expected, $time->getJulianTime(), '', 0.01);
    }

    public function providerTestGetJulianTime()
    {
        return array(
            array("2016-03-01 15:38:14", 2457449.1515509),
            array("1987-04-10 00:00:00", 2446895.5),
            array("1987-04-10 19:21:00", 2446896.30625),
            array("1985-02-17 06:00:00", 2446113.75),
            array("1990-01-00 00:00:00", 2447891.5),
            array("2000-01-01 12:00:00", 2451545.0),
            array("1600-12-31 00:00:00", 2305812.5),
            array("837-04-10 12:00:00", 2026872.0),
            array("837-04-10 07:12:00", 2026871.8),
            array("-1000-02-29 00:00:00", 1355866.5),
            array("-1001-08-17 21:36:00", 1355671.4),
            array("-4712-01-01 12:00:00", 0.0)
        );
    }

    /**
     * @dataProvider providerTestGetGreenwichMeanSiderealTime
     */
    public function testGetGreenwichMeanSiderealTime($datetime, $expected)
    {
        $time = new Time($datetime);
        $this->assertEquals($expected, $time->getGreenwichMeanSiderealTime(), '', 0.01);
    }

    public function providerTestGetGreenwichMeanSiderealTime()
    {
        return array(
            array("1987-04-10 00:00:00", 197.693),
            array("1987-04-10 19:21:00", 128.737),
            array("1980-04-22 14:36:51", 70.021)
        );
    }

    /**
     * @dataProvider providerTestGetLocalSiderealTime
     */
    public function testGetLocalSiderealTime($datetime, $lat, $lng, $expected)
    {
        $location = new Location($lat, $lng);
        $time = new Time($datetime);
        $this->assertEquals($expected, $time->getLocalSiderealTime($location), '', 0.01);
    }

    public function providerTestGetLocalSiderealTime()
    {
        return array(
            array("1980-04-22 14:36:51", 0, -64, 6.021)
        );
    }
}
