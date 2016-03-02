<?php

namespace StarAtlas\Models;

/**
 * Class Moon
 * @package StarAtlas\Models
 */
class Moon extends CelestialObject
{

    /**
     * @var float
     */
    protected $epochLongitude = 318.351648;
    /**
     * @var float
     */
    protected $perigeeLongitude = 36.340410;
    /**
     * @var float
     */
    protected $nodeLongitude = 318.510107;
    /**
     * @var float
     */
    protected $inclination = 5.145396;
    /**
     * @var float
     */
    protected $eccentricity = 0.054396;
    /**
     * @var float
     */
    protected $semiMajorAxis = 384401.0;
    /**
     * @var float
     */
    protected $angularSize = 0.5181;
    /**
     * @var float
     */
    protected $parallax = 0.9507;

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
     * @param float $nodeLongitude
     */
    public function setNodeLongitude($nodeLongitude)
    {
        $this->nodeLongitude = $nodeLongitude;
    }

    /**
     * @param float $inclination
     */
    public function setInclination($inclination)
    {
        $this->inclination = $inclination;
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
     * @param float $angularSize
     */
    public function setAngularSize($angularSize)
    {
        $this->angularSize = $angularSize;
    }

    /**
     * @param float $parallax
     */
    public function setParallax($parallax)
    {
        $this->parallax = $parallax;
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
    public function getPerigeeLongitude()
    {
        return $this->perigeeLongitude;
    }

    /**
     * @return float
     */
    public function getNodeLongitude()
    {
        return $this->nodeLongitude;
    }

    /**
     * @return float
     */
    public function getInclination()
    {
        return $this->inclination;
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
    public function getSemiMajorAxis()
    {
        return $this->semiMajorAxis;
    }

    /**
     * @return float
     */
    public function getAngularSize()
    {
        return $this->angularSize;
    }

    /**
     * @return float
     */
    public function getParallax()
    {
        return $this->parallax;
    }

    /**
     * @return float
     */
    protected function getJulianDays()
    {
        $jd1990 = gregoriantojd(1, 1, 1990) - 0.5;
        $julianDate = $this->time->getJulianTime();
        $days = $julianDate - $jd1990 + 1;
        return $days;
    }

    /**
     * @return float
     */
    public function getOrbitalLongitude()
    {
        $orbitalLongitude = 13.1763966 * $this->getJulianDays() + $this->getEpochLongitude();
        $orbitalLongitude = $this->bringWithinRange($orbitalLongitude, 360);
        return $orbitalLongitude;
    }

    /**
     * @return float
     */
    public function getMeanAnomaly()
    {
        $meanAnomaly = $this->getOrbitalLongitude() - 0.1114041 * $this->getJulianDays() - $this->getPerigeeLongitude();
        $meanAnomaly = $this->bringWithinRange($meanAnomaly, 360);
        return $meanAnomaly;
    }

    /**
     * @return float
     */
    public function getAscendingNodeLongitude()
    {
        $ascendingNodeLongitude = $this->nodeLongitude - 0.0529539 * $this->getJulianDays();
        $ascendingNodeLongitude = $this->bringWithinRange($ascendingNodeLongitude, 360);
        return $ascendingNodeLongitude;
    }

    /**
     * @return float
     */
    public function getEclipticalLatitude()
    {
        list($l2, $n1) = $this->getEclipticalData();
        return rad2deg(asin(sin(deg2rad($l2 - $n1)) * sin(deg2rad($this->inclination))));
    }

    /**
     * @return float
     */
    public function getEclipticalLongitude()
    {
        list($l2, $n1) = $this->getEclipticalData();
        return rad2deg(atan2(sin(deg2rad($l2 - $n1)) * cos(deg2rad($this->inclination)), cos(deg2rad($l2 - $n1)))) + $n1;
    }

    /**
     * @return array
     */
    protected function getEclipticalData()
    {
        $sunLong = $this->sun->getEclipticalLongitude();
        $sunMeanAnomaly = $this->sun->getMeanAnomaly();
        $c = $this->getOrbitalLongitude() - $sunLong;
        $ev = 1.2739 * sin(deg2rad(2 * $c - $this->getMeanAnomaly()));
        $ae = 0.1858 * sin(deg2rad($sunMeanAnomaly));
        $a3 = 0.37 * sin(deg2rad($sunMeanAnomaly));
        $correctedMeanAnomaly = $this->getMeanAnomaly() + $ev - $ae - $a3;
        $ec = 6.2886 * sin(deg2rad($correctedMeanAnomaly));
        $a4 = 0.214 * sin(deg2rad(2 * $correctedMeanAnomaly));
        $l1 = $this->getOrbitalLongitude() + $ev + $ec - $ae + $a4;
        $v = 0.6583 * sin(deg2rad(2 * ($l1 - $sunLong)));
        $l2 = $l1 + $v;
        $n1 = $this->getAscendingNodeLongitude() - (0.16 * sin(deg2rad($sunMeanAnomaly)));
        return array($l2, $n1);
    }

    /**
     * @return float
     */
    public function getPhase()
    {
        // Todo: calculate phase of the moon
        return 0;
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
        return array();
    }
}
