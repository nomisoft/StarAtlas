<?php

namespace StarAtlas\Models;

/**
 * Class Planet
 * @package StarAtlas\Models
 */
class Planet extends CelestialObject
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var float
     */
    protected $period;
    /**
     * @var float
     */
    protected $epochLongitude;
    /**
     * @var float
     */
    protected $perihelionLongitude;
    /**
     * @var float
     */
    protected $eccentricity;
    /**
     * @var float
     */
    protected $semiMajorAxis;
    /**
     * @var float
     */
    protected $inclination;
    /**
     * @var float
     */
    protected $ascendingNodeLongitude;
    /**
     * @var float
     */
    protected $angularDiameter1au;
    /**
     * @var float
     */
    protected $magnitude1au;

    /**
     * @var Earth
     */
    protected $earth;

    /**
     * @param Time $time
     * @param Location $location
     * @param Earth $earth
     */
    public function __construct(Time $time, Location $location, Earth $earth = null)
    {
        parent::__construct($time, $location);
        $this->earth = $earth;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param float $period
     */
    public function setPeriod($period)
    {
        $this->period = $period;
    }

    /**
     * @param float $epochLongitude
     */
    public function setEpochLongitude($epochLongitude)
    {
        $this->epochLongitude = $epochLongitude;
    }

    /**
     * @param float $perihelionLongitude
     */
    public function setPerihelionLongitude($perihelionLongitude)
    {
        $this->perihelionLongitude = $perihelionLongitude;
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
     * @param float $inclination
     */
    public function setInclination($inclination)
    {
        $this->inclination = $inclination;
    }

    /**
     * @param float $ascendingNodeLongitude
     */
    public function setAscendingNodeLongitude($ascendingNodeLongitude)
    {
        $this->ascendingNodeLongitude = $ascendingNodeLongitude;
    }

    /**
     * @param float $angularDiameter1au
     */
    public function setAngularDiameter1Au($angularDiameter1au)
    {
        $this->angularDiameter1au = $angularDiameter1au;
    }

    /**
     * @param float $magnitude1au
     */
    public function setMagnitude1au($magnitude1au)
    {
        $this->magnitude1au = $magnitude1au;
    }


    /**
     * @return int
     */
    public function getId()
    {
        return intval($this->id);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getPeriod()
    {
        return floatval($this->period);
    }

    /**
     * @return float
     */
    public function getEpochLongitude()
    {
        return floatval($this->epochLongitude);
    }

    /**
     * @return float
     */
    public function getPerihelionLongitude()
    {
        return floatval($this->perihelionLongitude);
    }

    /**
     * @return float
     */
    public function getEccentricity()
    {
        return floatval($this->eccentricity);
    }

    /**
     * @return float
     */
    public function getSemiMajorAxis()
    {
        return floatval($this->semiMajorAxis);
    }

    /**
     * @return float
     */
    public function getInclination()
    {
        return floatval($this->inclination);
    }

    /**
     * @return float
     */
    public function getAscendingNodeLongitude()
    {
        return floatval($this->ascendingNodeLongitude);
    }

    /**
     * @return float
     */
    public function getAngularDiameter1Au()
    {
        return floatval($this->angularDiameter1au);
    }

    /**
     * @return float
     */
    public function getMagnitude1au()
    {
        return floatval($this->magnitude1au);
    }

    /**
     * @return float
     */
    public function getNp()
    {
        $julianDate1990 = gregoriantojd(1, 1, 1990) - 0.5;
        $julianDate = $this->time->getJulianTime();
        $days = $julianDate - $julianDate1990 + 1;
        $np = (360 / 365.242191) * ($days / $this->getPeriod());
        $np = $this->bringWithinRange($np, 360);
        return $np;
    }

    /**
     * @return float
     */
    public function getMeanAnomaly()
    {
        $meanAnomaly = $this->getNp() + $this->getEpochLongitude() - $this->getPerihelionLongitude();
        $meanAnomaly = $this->bringWithinRange($meanAnomaly, 360);
        return $meanAnomaly;
    }

    /**
     * @return float
     */
    public function getHeliocentricLongitude()
    {
        $heliocentricLongitude = $this->getNp() + ((360 / pi()) * $this->getEccentricity() * sin(deg2rad($this->getMeanAnomaly()))) + $this->getEpochLongitude();
        $heliocentricLongitude = $this->bringWithinRange($heliocentricLongitude, 360);
        return $heliocentricLongitude;
    }

    /**
     * @return float
     */
    public function getVariation()
    {
        return $this->getHeliocentricLongitude() - $this->getPerihelionLongitude();
    }

    /**
     * @return float
     */
    public function getSunDistance()
    {
        return ($this->getSemiMajorAxis() * (1 - ($this->getEccentricity() * $this->getEccentricity()))) / (1 + ($this->getEccentricity() * cos($this->getVariation())));
    }

    /**
     * @return float
     */
    public function getHeliocentricLatitude()
    {
        return rad2deg(asin(
            sin(deg2rad($this->getHeliocentricLongitude() - $this->getAscendingNodeLongitude())) * sin(deg2rad($this->getInclination()))
        ));
    }

    /**
     * @return float
     */
    public function getProjectedHeliocentricLongitude()
    {
        $y = sin(deg2rad($this->getHeliocentricLongitude() - $this->getAscendingNodeLongitude())) * cos(deg2rad($this->inclination));
        $x = cos(deg2rad($this->getHeliocentricLongitude() - $this->getAscendingNodeLongitude()));
        $t = atan2($y, $x);
        $t = rad2deg($t);
        return $t + $this->getAscendingNodeLongitude();
    }

    /**
     * @return float
     */
    public function getProjectedRadiusVector()
    {
        return $this->getSunDistance() * cos(deg2rad($this->getHeliocentricLatitude()));
    }

    /**
     * @return float
     */
    public function getEclipticalLongitude()
    {
        $l = $this->earth->getHeliocentricLongitude();
        $r = $this->earth->getSunDistance();
        if ($this->getSunDistance() < 1) { //inner planet
            $a = rad2deg(atan(($this->getProjectedRadiusVector() * sin(deg2rad($l - $this->getProjectedHeliocentricLongitude()))) / ($r - ($this->getProjectedRadiusVector() * cos(deg2rad($l - $this->getProjectedHeliocentricLongitude()))))));
            return 180 + $l + $a;
        } else { //outer planet
            $eclipticalLongitude = rad2deg(
                atan(
                    ($r * sin(deg2rad($this->getProjectedHeliocentricLongitude() - $this->getHeliocentricLongitude())))
                    /
                    ($this->getProjectedRadiusVector() - ($r * cos(deg2rad($this->getProjectedHeliocentricLongitude() - $this->getHeliocentricLongitude()))))
                )
            ) + $this->getProjectedHeliocentricLongitude();
            $eclipticalLongitude = $this->bringWithinRange($eclipticalLongitude, 360);
            return $eclipticalLongitude;
        }
    }

    /**
     * @return float
     */
    public function getEclipticalLatitude()
    {
        $l = $this->earth->getHeliocentricLongitude();
        $r = $this->earth->getSunDistance();
        return rad2deg(atan(
            ($this->getProjectedRadiusVector() * tan(deg2rad($this->getHeliocentricLatitude())) * sin(deg2rad($this->getEclipticalLongitude() - $this->getProjectedHeliocentricLongitude())))
            /
            ($r * sin(deg2rad($this->getProjectedHeliocentricLongitude() - $l)))
        ));
    }

    /**
     * @return float
     */
    public function getEarthDistance()
    {
        $l = $this->earth->getHeliocentricLongitude();
        $r = $this->earth->getSunDistance();
        return sqrt(($r * $r) + ($this->getSunDistance() * $this->getSunDistance()) - (2 * $r * $this->getSunDistance() * cos(deg2rad($this->getHeliocentricLongitude() - $l))));
    }

    /**
     * @return float
     */
    public function getAngularSeparation()
    {
        return $this->getAngularDiameter1Au() / $this->getEarthDistance();
    }

    /**
     * @return float
     */
    public function getPhase()
    {
        return (1 + cos(deg2rad($this->getEclipticalLongitude() - $this->getHeliocentricLongitude()))) / 2;
    }

    /**
     * @return float
     */
    public function getApparentMagnitude()
    {
        return 5 * log(($this->getSunDistance() * $this->getEarthDistance()) / sqrt($this->getPhase()), 10) + $this->getMagnitude1au();
    }

    /**
     * @return float
     */
    public function getLightTime()
    {
        return (($this->getEarthDistance() * 149598000000) / 299792458) / 60 / 60;
    }

    /**
     * @return float
     */
    public function getDeclination()
    {
        $epochLongitude = deg2rad(23.440527);
        return rad2deg(asin(sin(deg2rad($this->getEclipticalLatitude())) * cos($epochLongitude) + cos(deg2rad($this->getEclipticalLatitude())) * sin($epochLongitude) * sin(deg2rad($this->getEclipticalLongitude()))));
    }

    /**
     * @return float
     */
    public function getRightAscension()
    {
        $epochLongitude = deg2rad(23.440527);
        $y = sin(deg2rad($this->getEclipticalLongitude())) * cos($epochLongitude) - tan(deg2rad($this->getEclipticalLatitude())) * sin($epochLongitude);
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
            'id' => $this->getId(),
            'name' => $this->getName(),
            'altitude' => $this->getAltitude(),
            'angular_diameter_1au' => $this->getAngularDiameter1Au(),
            'angular_separation' => $this->getAngularSeparation(),
            'apparent_magnitude' => $this->getApparentMagnitude(),
            'ascending_node_longitude' => $this->getAscendingNodeLongitude(),
            'azimuth' => $this->getAzimuth(),
            'declination' => $this->getDeclination(),
            'earth_distance' => $this->getEarthDistance(),
            'eccentricity' => $this->getEccentricity(),
            'ecliptical_latitude' => $this->getEclipticalLatitude(),
            'ecliptical_longitude' => $this->getEclipticalLongitude(),
            'epoch_longitude' => $this->getEpochLongitude(),
            'heliocentric_latitude' => $this->getHeliocentricLatitude(),
            'heliocentric_longitude' => $this->getHeliocentricLongitude(),
            'hour_angle' => $this->getHourAngle(),
            'inclination' => $this->getInclination(),
            'light_time' => $this->getLightTime(),
            'magnitude_1au' => $this->getMagnitude1au(),
            'mean_anomaly' => $this->getMeanAnomaly(),
            'perihelion_longitude' => $this->getPerihelionLongitude(),
            'period' => $this->getPeriod(),
            'phase' => $this->getPhase(),
            'projected_heliocentric_longitude' => $this->getProjectedHeliocentricLongitude(),
            'projected_radius_vector' => $this->getProjectedRadiusVector(),
            'right_ascension' => $this->getRightAscension(),
            'semi_major_axis' => $this->getSemiMajorAxis(),
            'sun_distance' => $this->getSunDistance(),
            'variation' => $this->getVariation(),
        );
    }
}
