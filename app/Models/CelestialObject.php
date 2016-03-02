<?php

namespace StarAtlas\Models;

/**
 * Class CelestialObject
 * @package StarAtlas\Models
 */
abstract class CelestialObject implements \JsonSerializable
{

    /**
     * @var Time
     */
    protected $time;
    /**
     * @var Location
     */
    protected $location;
    /**
     * @var Earth
     */
    protected $earth;
    /**
     * @var Sun
     */
    protected $sun;

    /**
     * @return float
     */
    abstract protected function getDeclination();

    /**
     * @return float
     */
    abstract protected function getRightAscension();

    /**
     * @param Time $time
     * @param Location $location
     * @param Earth $earth
     * @param Sun $sun
     */
    public function __construct(Time $time, Location $location, Earth $earth = null, Sun $sun = null)
    {
        $this->time = $time;
        $this->location = $location;
        $this->earth = $earth;
        $this->sun = $sun;
    }

    /**
     * @param $num
     * @param $range
     * @return float
     */
    protected function bringWithinRange($num, $range)
    {
        $num = fmod($num, $range);
        if ($num < 0) {
            $num += $range;
        }
        return $num;
    }

    /**
     * @return float
     */
    public function getHourAngle()
    {
        $hourAngle = $this->time->getLocalSiderealTime($this->location) - $this->getRightAscension();
        if ($hourAngle < 0) {
            $hourAngle += 360;
        }
        return $hourAngle;
    }


    /**
     * @return float
     */
    public function getAzimuth()
    {
        $hourAngle = deg2rad($this->getHourAngle());
        $declination = deg2rad($this->getDeclination());
        $lat = deg2rad($this->location->getLatitude());
        $azimuth = acos((sin($declination) - (sin($lat) * sin(deg2rad($this->getAltitude())))) / (cos($lat) * cos(deg2rad($this->getAltitude()))));
        $azimuth = rad2deg($azimuth);
        if (sin($hourAngle) > 0) {
            $azimuth = 360 - $azimuth;
        }

        return $azimuth;
    }

    /**
     * @return float
     */
    public function getAltitude()
    {
        $hourAngle = deg2rad($this->getHourAngle());
        $declination = deg2rad($this->getDeclination());
        $lat = deg2rad($this->location->getLatitude());
        $altitude = asin(sin($declination) * sin($lat) + cos($declination) * cos($lat) * cos($hourAngle));
        $altitude = rad2deg($altitude);
        return $altitude;
    }
}
