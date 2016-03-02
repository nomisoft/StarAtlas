<?php

namespace StarAtlas\Models;

/**
 * Class Time
 * @package StarAtlas\Models
 */
class Time extends \DateTime
{

    /**
     * @param string $time
     * @param \DateTimeZone $timezone
     */
    public function __construct($time = "now", \DateTimeZone $timezone = null)
    {
        parent::__construct($time, $timezone);
    }

    /**
     * @return string
     */
    public function getYear()
    {
        return $this->format("Y");
    }

    /**
     * @return string
     */
    public function getMonth()
    {
        return $this->format("n");
    }

    /**
     * @return string
     */
    public function getDay()
    {
        return $this->format("j");
    }

    /**
     * @return string
     */
    public function getHour()
    {
        return $this->format("H");
    }

    /**
     * @return string
     */
    public function getMinute()
    {
        return $this->format("i");
    }

    /**
     * @return string
     */
    public function getSecond()
    {
        return $this->format("s");
    }

    /**
     * @return float
     */
    public function getJulianTime()
    {
        $julianDate = gregoriantojd($this->getMonth(), $this->getDay(), $this->getYear());
        $julianDate += (($this->getHour() - 12) / 24) + ($this->getMinute() / (24 * 60)) + ($this->getSecond() / (24 * 60 * 60));
        return $julianDate;
    }

    /**
     * @return float
     */
    public function getGreenwichMeanSiderealTime()
    {
        $j2000 = 2451545;
        $julianDate = $this->getJulianTime();
        $t = ($julianDate - $j2000) / 36525;
        $gmst = 280.46061837 + 360.98564736629 * ($julianDate - $j2000) + (0.000387933 * pow($t, 2)) - (pow($t, 3)) / 38710000;
        $gmst = fmod($gmst, 360);
        if ($gmst < 0) {
            $gmst += 360;
        }
        return $gmst;
    }

    /**
     * @param Location $location
     * @return float
     */
    public function getLocalSiderealTime(Location $location)
    {
        return $this->getGreenwichMeanSiderealTime() + $location->getLongitude();
    }
}
