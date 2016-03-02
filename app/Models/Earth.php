<?php

namespace StarAtlas\Models;

/**
 * Class Earth
 * @package StarAtlas\Models
 */
class Earth extends Planet
{

    /**
     * @var int
     */
    protected $id = 3;
    /**
     * @var string
     */
    protected $name = 'Earth';
    /**
     * @var float
     */
    protected $period = 1.000004;
    /**
     * @var float
     */
    protected $epochLongitude = 99.403308;
    /**
     * @var float
     */
    protected $perihelionLongitude = 102.768413;
    /**
     * @var float
     */
    protected $eccentricity = 0.016713;
    /**
     * @var float
     */
    protected $semiMajorAxis = 1.000000;
    /**
     * @var float
     */
    protected $inclination = 0.0;
    /**
     * @var float
     */
    protected $ascendingNodeLongitude = 0.0;
    /**
     * @var float
     */
    protected $angularDiameter1au = 0.0;
    /**
     * @var float
     */
    protected $magnitude1au = 0.0;
}
