<?php

namespace StaticRouter\Tests\Feature\PatientsMetricsController;

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
            $res = $this->client->request('GET', 'http://localhost:8000/patients/1/metrics');
            $this->assertEquals('200', $res->getStatusCode());
            $this->assertEquals('got to index for patient 1', $res->getBody()->getContents());
        } catch (GuzzleException $e) {
            $this->fail('GuzzleException: ' . $e->getMessage());
        }
    }


    public function testPatientsGet() :void
    {
        try {
            $res = $this->client->request('GET', 'http://localhost:8000/patients/1/metrics/abc');
            $this->assertEquals($res->getStatusCode(), '200');
            $this->assertEquals(['patient_id' => '1', 'metrics_id' => 'abc'], json_decode($res->getBody()->getContents(), true));
        } catch (GuzzleException $e) {
            $this->fail('GuzzleException: ' . $e->getMessage());
        }
    }
}