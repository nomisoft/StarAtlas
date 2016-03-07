<?php

namespace StarAtlas\Models;

/**
 * Class Sun
 * @package StarAtlas\Models
 */
class Sun extends CelestialObject
{

    /**
     * @var float
     */
    protected $epochLongitude = 279.403303;
    /**
     * @var float
     */
    protected $perigeeLongitude = 282.768422;
    /**
     * @var float
     */
    protected $eccentricity = 0.016713;
    /**
     * @var float
     */
    protected $semiMajorAxis = 149598500;
    /**
     * @var float
     */
    protected $angularDiameter = 0.533128;

    /**
     * @param float $epochLongitude
     */
    public function setEpochLongitude($epochLongitude)
    {
        $this->epochLongitude = $epochLongitude;
    }

    /**
     * @param float $perigeeLongitude
     */
    public function setPerigeeLongitude($perigeeLongitude)
    {
        $this->perigeeLongitude = $perigeeLongitude;
    }

    /**
     * @param float $eccentricity
     */
    public function setEccentricity($eccentricity)
    {
        $this->eccentricity = $eccentricity;
    }

    /**
     * @param float $semiMajorAxis
     */
    public function setSemiMajorAxis($semiMajorAxis)
    {
        $this->semiMajorAxis = $semiMajorAxis;
    }

    /**
     * @param float $angularDiameter
     */
    public function setAngularDiameter($angularDiameter)
    {
        $this->angularDiameter = $angularDiameter;
    }


    /**
     * @return float
     */
    public function getAngularDiameter()
    {
        return $this->angularDiameter;
    }

    /**
     * @return float
     */
    public function getSemiMajorAxis()
    {
        return $this->semiMajorAxis;
    }

    /**
     * @return float
     */
    public function getEccentricity()
    {
        return $this->eccentricity;
    }

    /**
     * @return float
     */
    public function getPerigeeLongitude()
    {
        return $this->perigeeLongitude;
    }

    /**
     * @return float
     */
    public function getEpochLongitude()
    {
        return $this->epochLongitude;
    }

    /**
     * @return float
     */
    public function getMeanAnomaly()
    {
        $jd1990 = gregoriantojd(1, 1, 1990) - 0.5;
        $julianDate = $this->time->getJulianTime();
        $days = $julianDate - $jd1990 + 1;
        $n = (360 / 365.242191) * $days;
        $n = $this->bringWithinRange($n, 360);
        $meanAnomaly = $n + $this->getEpochLongitude() - $this->getPerigeeLongitude();
        $meanAnomaly = $this->bringWithinRange($meanAnomaly, 360);
        return $meanAnomaly;
    }

    /**
     * @return float
     */
    public function getTrueAnomaly()
    {
        return $this->getMeanAnomaly() + (360 / pi()) * $this->getEccentricity() * sin(deg2rad($this->getMeanAnomaly()));
    }

    /**
     * @return float
     */
    public function getEclipticalLatitude()
    {
        return 0.0;
    }

    /**
     * @return float
     */
    public function getEclipticalLongitude()
    {
        $eclipticalLongitude = $this->getTrueAnomaly() + $this->getPerigeeLongitude();
        $eclipticalLongitude = $this->bringWithinRange($eclipticalLongitude, 360);
        return $eclipticalLongitude;
    }

    /**
     * @return float
     */
    public function getDeclination()
    {
        $epochLong = deg2rad(23.440527);
        return rad2deg(asin(sin(deg2rad($this->getEclipticalLatitude())) * cos($epochLong) + cos(deg2rad($this->getEclipticalLatitude())) * sin($epochLong) * sin(deg2rad($this->getEclipticalLongitude()))));
    }

    /**
     * @return float
     */
    public function getRightAscension()
    {
        $epochLong = deg2rad(23.440527);
        $y = sin(deg2rad($this->getEclipticalLongitude())) * cos($epochLong) - tan(deg2rad($this->getEclipticalLatitude())) * sin($epochLong);
        $x = cos(deg2rad($this->getEclipticalLongitude()));
        $rightAscension = rad2deg(atan2($y, $x));
        $rightAscension = $this->bringWithinRange($rightAscension, 360);
        return $rightAscension;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return array(
            'epoch_longitude' => $this->getEpochLongitude()
        );
    }
}
