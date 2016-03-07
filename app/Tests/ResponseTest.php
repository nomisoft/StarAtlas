<?php

namespace StarAtlas\Tests;

use StarAtlas\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase
{

    public function testSetBody()
    {
        $response = new Response('foo');
        $response->send();
        $this->expectOutputString('foo');
    }

}
