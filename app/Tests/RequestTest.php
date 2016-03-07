<?php

namespace StarAtlas\Tests;

use StarAtlas\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{

    public function testGet()
    {
        $_GET['foo'] = 'bar';
        $request = new Request($GLOBALS);
        $this->assertEquals('bar', $request->get('foo'));
    }

    public function testPost()
    {
        $_POST['foo'] = 'bar';
        $request = new Request($GLOBALS);
        $this->assertEquals('bar', $request->post('foo'));
    }

    public function testRequest()
    {
        $_REQUEST['foo'] = 'bar';
        $request = new Request($GLOBALS);
        $this->assertEquals('bar', $request->request('foo'));
    }

    public function testServerPort()
    {
        $request = new Request($GLOBALS);
        $this->assertNotFalse($request->server('PHP_SELF'));
    }

    public function testSession()
    {
        $_SESSION['foo'] = 'bar';
        $request = new Request($GLOBALS);
        $this->assertEquals('bar', $request->session('foo'));
    }
}
