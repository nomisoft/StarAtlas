<?php
namespace StarAtlas\Controllers;

use StarAtlas\Models\Time;
use StarAtlas\Models\Location;
use StarAtlas\Models\Earth;
use StarAtlas\Models\Moon;
use StarAtlas\Models\Sun;
use StarAtlas\Request;
use StarAtlas\Response;

/**
 * Class Controller
 * @package StarAtlas\Controllers
 */
class Controller
{

    /**
     * @var \PDO
     */
    private $db;

    /**
     * @var Time
     */
    public $time;
    /**
     * @var Location
     */
    public $location;
    /**
     * @var Earth
     */
    public $earth;

    /**
     * @param Request $request
     * @param string $db
     */
    public function __construct(Request $request, $db)
    {
        var_dump($request);
        $this->db = $db;
        $this->setLocation($request);
        $this->setTime($request);
        $this->setEarth();
    }

    private function setLocation(Request $request)
    {
        $latitude = $request->get('latitude') != false ? $request->get('latitude') : 0;
        $longitude = $request->get('longitude') != false ? $request->get('longitude') : 0;
        $this->location = new Location($latitude, $longitude);
    }

    private function setTime(Request $request)
    {
        $this->time = new Time();
        if ($request->get('year') !== false) {
            $this->time->setYear($request->get('year'));
        }
        if ($request->get('month') !== false) {
            $this->time->setMonth($request->get('month'));
        }
        if ($request->get('day') !== false) {
            $this->time->setDay($request->get('day'));
        }
        if ($request->get('hour') !== false) {
            $this->time->setHour($request->get('hour'));
        }
        if ($request->get('minute') !== false) {
            $this->time->setMinute($request->get('minute'));
        }
        if ($request->get('second') !== false) {
            $this->time->setSecond($request->get('second'));
        }
    }

    private function setEarth()
    {
        $statement = $this->db->prepare("SELECT * FROM planets WHERE `name` = 'Earth' LIMIT 1");
        $statement->execute();
        $statement->setFetchMode(\PDO::FETCH_CLASS, "\\StarAtlas\\Models\\Earth", array($this->time, $this->location));
        $this->earth = $statement->fetch();
    }

    /**
     * @return Response
     */
    public function indexAction()
    {
        $response = new Response();
        return $response;
    }

    /**
     * @return Response
     */
    public function planetsAction()
    {
        $statement = $this->db->query("SELECT * FROM planets");
        $statement->setFetchMode(
            \PDO::FETCH_CLASS,
            "\\StarAtlas\\Models\\Planet",
            array($this->time, $this->location, $this->earth)
        );
        $planets = $statement->fetchAll();
        $response = new Response(json_encode($planets));
        return $response;
    }

    /**
     * @param string $planet
     * @return Response
     */
    public function planetAction($planet)
    {
        $statement = $this->db->prepare("SELECT * FROM planets WHERE name = :planet LIMIT 1");
        $statement->bindParam(':planet', $planet, \PDO::PARAM_STR);
        $statement->execute();
        $statement->setFetchMode(
            \PDO::FETCH_CLASS,
            "\\StarAtlas\\Models\\Planet",
            array($this->time, $this->location, $this->earth)
        );
        $planet = $statement->fetchAll();
        $response = new Response(json_encode($planet));
        return $response;
    }

    /**
     * @return Response
     */
    public function starsAction()
    {
        $statement = $this->db->query("SELECT * FROM stars WHERE apparentMagnitude < 5");
        $statement->setFetchMode(
            \PDO::FETCH_CLASS,
            "\\StarAtlas\\Models\\Star",
            array($this->time, $this->location, $this->earth)
        );
        $stars = $statement->fetchAll();
        $response = new Response(json_encode($stars));
        return $response;
    }

    /**
     * @param int $star
     * @return Response
     */
    public function starAction($star)
    {
        $statement = $this->db->prepare("SELECT * FROM stars WHERE catalogueNumber = :star LIMIT 1");
        $statement->bindParam(':star', $star, \PDO::PARAM_STR);
        $statement->execute();
        $statement->setFetchMode(
            \PDO::FETCH_CLASS,
            "\\StarAtlas\\Models\\Star",
            array($this->time, $this->location, $this->earth)
        );
        $star = $statement->fetchAll();
        $response = new Response(json_encode($star));
        return $response;
    }


    /**
     * @return Response
     */
    public function moonAction()
    {
        $moon = new Moon($this->time, $this->location, $this->earth);
        $response = new Response(json_encode($moon));
        return $response;
    }


    /**
     * @return Response
     */
    public function sunAction()
    {
        $sun = new Sun($this->time, $this->location);
        $response = new Response(json_encode($sun));
        return $response;
    }
}
