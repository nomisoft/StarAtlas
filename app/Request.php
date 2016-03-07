<?php

namespace StarAtlas;

class Request
{

    private $get;

    private $post;

    private $request;

    private $files;

    private $cookie;

    private $server;

    private $session;

    public function __construct($globals)
    {
        $this->fromGlobals($globals);
    }

    private function fromGlobals($globals)
    {
        $properties = array(
            'get' => '_GET',
            'post' => '_POST',
            'request' => '_REQUEST',
            'files' => '_FILES',
            'cookie' => '_COOKIE',
            'server' => '_SERVER',
            'session' => '_SESSION',
        );
        foreach ($properties as $key => $value) {
            if (isset($globals[$value])) {
                $this->$key = $globals[$value];
            }
        }
    }

    public function get($key)
    {
        if (array_key_exists($key, $this->get)) {
            return $this->get[$key];
        }
        return false;
    }

    public function post($key)
    {
        if (array_key_exists($key, $this->post)) {
            return $this->post[$key];
        }
        return false;
    }

    public function request($key)
    {
        if (array_key_exists($key, $this->request)) {
            return $this->request[$key];
        }
        return false;
    }

    public function file($key)
    {
        if (array_key_exists($key, $this->files)) {
            return $this->files[$key];
        }
        return false;
    }

    public function cookie($key)
    {
        if (array_key_exists($key, $this->cookie)) {
            return $this->cookie[$key];
        }
        return false;
    }

    public function server($key)
    {
        if (array_key_exists($key, $this->server)) {
            return $this->server[$key];
        }
        return false;
    }

    public function session($key)
    {
        if (array_key_exists($key, $this->session)) {
            return $this->session[$key];
        }
        return false;
    }
}
