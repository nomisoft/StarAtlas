<?php
namespace StarAtlas\Controllers;

use StarAtlas\App;

/**
 * Class Controller
 * @package StarAtlas\Controllers
 */
class Controller
{

    /**
     * @var App
     */
    protected $app;

    /**
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     *
     */
    public function indexAction()
    {
    }

    /**
     *
     */
    public function planetsAction()
    {
        $statement = $this->app->getDbConnection()->query("SELECT * FROM planets");
        $statement->setFetchMode(
            \PDO::FETCH_CLASS,
            "\\StarAtlas\\Models\\Planet",
            array($this->app->time, $this->app->location, $this->app->earth)
        );
        $planets = $statement->fetchAll();
        echo json_encode($planets);
    }

    /**
     * @param string $planet
     */
    public function planetAction($planet)
    {
        $statement = $this->app->getDbConnection()->prepare("SELECT * FROM planets WHERE name = :planet LIMIT 1");
        $statement->bindParam(':planet', $planet, \PDO::PARAM_STR);
        $statement->execute();
        $statement->setFetchMode(
            \PDO::FETCH_CLASS,
            "\\StarAtlas\\Models\\Planet",
            array($this->app->time, $this->app->location, $this->app->earth)
        );
        $planet = $statement->fetchAll();
        echo json_encode($planet);
    }

    /**
     *
     */
    public function starsAction()
    {
        $statement = $this->app->getDbConnection()->query("SELECT * FROM stars WHERE apparentMagnitude < 5");
        $statement->setFetchMode(
            \PDO::FETCH_CLASS,
            "\\StarAtlas\\Models\\Star",
            array($this->app->time, $this->app->location, $this->app->earth)
        );
        $stars = $statement->fetchAll();
        echo json_encode($stars);
    }

    /**
     * @param int $star
     */
    public function starAction($star)
    {
        $statement = $this->app->getDbConnection()->prepare("SELECT * FROM stars WHERE catalogueNumber = :star LIMIT 1");
        $statement->bindParam(':star', $star, \PDO::PARAM_STR);
        $statement->execute();
        $statement->setFetchMode(
            \PDO::FETCH_CLASS,
            "\\StarAtlas\\Models\\Star",
            array($this->app->time, $this->app->location, $this->app->earth)
        );
        $star = $statement->fetchAll();
        echo json_encode($star);
    }
}
