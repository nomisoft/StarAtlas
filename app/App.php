<?php

namespace StarAtlas;

use Symfony\Component\Yaml\Parser;
use \StarAtlas\Models\Location;
use \StarAtlas\Models\Time;
use \StarAtlas\Models\Earth;
use \StarAtlas\Controllers\Controller;

/**
 * Class App
 * @package StarAtlas
 */
class App
{

    /**
     * @var \PDO
     */
    private $db;
    /**
     * @var array
     */
    private $config;
    /**
     * @var array
     */
    private $routes;


    /**
     *
     */
    public function __construct()
    {
        $parser = new Parser();
        $this->config = $parser->parse(file_get_contents(__DIR__ . '/config.yml'));
        $this->db = new \PDO('mysql:host=' . $this->config['host'] . ';dbname=' . $this->config['dbname'], $this->config['user'], $this->config['password']);
    }

    /**
     * @param $key
     * @return bool|mixed
     */
    public function getConfigValue($key)
    {
        if (array_key_exists($key, $this->config)) {
            return $this->config[$key];
        }
        return false;
    }

    /**
     * @param array $routes
     */
    public function addRoutes($routes)
    {
        foreach ($routes as $route) {
            $this->addRoute($route[0], $route[1]);
        }
    }

    /**
     * @param string $pattern
     * @param string $functionName
     */
    public function addRoute($pattern, $functionName)
    {
        $this->routes['{' . $pattern . '}'] = $functionName;
    }

    /**
     * @param $requestUri
     * @return bool|mixed
     */
    public function run($requestUri)
    {
        foreach ($this->routes as $pattern => $function) {
            if (preg_match($pattern, $requestUri, $params)) {
                $controller = new Controller(new Request($GLOBALS), $this->db);
                array_shift($params);
                $response = call_user_func_array(array($controller, $function . 'Action'), array_values($params));
                $response->send();
            }
        }
        return false;
    }
}
