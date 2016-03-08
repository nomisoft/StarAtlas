<?php

namespace StarAtlas\Models;

/**
 * Class Star
 * @package StarAtlas\Models
 */
class Star extends CelestialObject
{

    /**
     * @var int
     */
    protected $catalogueNumber;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var float
     */
    protected $rightAscension;
    /**
     * @var float
     */
    protected $declination;
    /**
     * @var float
     */
    protected $apparentMagnitude;
    /**
     * @var float
     */
    protected $distance;
    /**
     * @var float
     */
    protected $bv;

    /**
     * @param int $catalogueNumber
     */
    public function setCatalogueNumber($catalogueNumber)
    {
        $this->catalogueNumber = $catalogueNumber;
    }

    /**
     * @param float $bv
     */
    public function setBv($bv)
    {
        $this->bv = $bv;
    }

    /**
     * @param float $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }

    /**
     * @param float $apparentMagnitude
     */
    public function setApparentMagnitude($apparentMagnitude)
    {
        $this->apparentMagnitude = $apparentMagnitude;
    }

    /**
     * @param float $declination
     */
    public function setDeclination($declination)
    {
        $this->declination = $declination;
    }

    /**
     * @param float $rightAscension
     */
    public function setRightAscension($rightAscension)
    {
        $this->rightAscension = $rightAscension;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getCatalogueNumber()
    {
        return intval($this->catalogueNumber);
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
    public function getRightAscension()
    {
        return floatval($this->rightAscension);
    }

    /**
     * @return float
     */
    public function getDistance()
    {
        return floatval($this->distance);
    }

    /**
     * @return float
     */
    public function getDeclination()
    {
        return floatval($this->declination);
    }

    /**
     * @return float
     */
    public function getApparentMagnitude()
    {
        return floatval($this->apparentMagnitude);
    }

    /**
     * @return float
     */
    public function getBV()
    {
        return floatval($this->bv);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return array(
            'catalogue_number' => $this->getCatalogueNumber(),
            'name' => $this->getName(),
            'altitude' => $this->getAltitude(),
            'apparent_magnitude' => $this->getApparentMagnitude(),
            'azimuth' => $this->getAzimuth(),
            'bv' => $this->getBV(),
            'declination' => $this->getDeclination(),
            'distance' => $this->getDistance(),
            'hour_angle' => $this->getHourAngle(),
            'right_ascension' => $this->getRightAscension()
        );
    }
}
