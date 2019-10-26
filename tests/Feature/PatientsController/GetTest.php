<?php

namespace StaticRouter\Tests\Feature\PatientsController;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use StaticRouter\StaticRouter;

class GetTest extends TestCase {

    protected $client;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->client = new Client();;
    }

    public function testPatientsIndex() :void
    {
        try {
            $res = $this->client->request('GET', 'http://localhost:8000/patients');
            $this->assertEquals('200', $res->getStatusCode());
            $this->assertEquals('got to patient Data', $res->getBody()->getContents());
        } catch (GuzzleException $e) {
            $this->fail('GuzzleException: ' . $e->getMessage());
        }
    }


    public function testPatientsGet() :void
    {
        try {
            $res = $this->client->request('GET', 'http://localhost:8000/patients/1');
            $this->assertEquals($res->getStatusCode(), '200');
            $this->assertEquals('1', $res->getBody()->getContents());
        } catch (GuzzleException $e) {
            $this->fail('GuzzleException: ' . $e->getMessage());
        }
    }

    public function testEmptyUrl() :void
    {
        try {
            $res = $this->client->request('GET', 'http://localhost:8000/');
            $this->assertEquals($res->getStatusCode(), '200');
            $this->assertEquals('Hello World', $res->getBody()->getContents());
        } catch (GuzzleException $e) {
            $this->fail('GuzzleException: ' . $e->getMessage());
        }
    }
}