<?php

namespace StarAtlas\Models;

/**
 * Class Location
 * @package StarAtlas\Models
 */
class Location
{

    /**
     * @var float
     */
    private $latitude;
    /**
     * @var float
     */
    private $longitude;

    /**
     * @param null $latitude
     * @param null $longitude
     */
    public function __construct($latitude = null, $longitude = null)
    {
        if (!is_null($latitude)) {
            $this->setLatitude($latitude);
        }
        if (!is_null($longitude)) {
            $this->setLongitude($longitude);
        }
    }

    /**
     * @param $latitude
     */
    public function setLatitude($latitude)
    {
        if (!is_numeric($latitude)) {
            throw new \InvalidArgumentException;
        }
        $this->latitude = fmod($latitude, 90);
    }

    /**
     * @param $longitude
     */
    public function setLongitude($longitude)
    {
        if (!is_numeric($longitude)) {
            throw new \InvalidArgumentException;
        }
        $this->longitude = fmod($longitude, 180);
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
}
