<?php

namespace StaticRouter\Tests\Feature\PatientsMetricsController;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;

class DeleteTest extends TestCase {

    protected $client;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->client = new Client();
    }

    public function testPatientDelete(): void
    {
        try {
            $res = $this->client->request('DELETE', 'http://localhost:8000/patients/1/metrics/abc');
            $this->assertEquals($res->getStatusCode(), '200');
            $this->assertEquals(['patient_id' => '1', 'metrics_id' => 'abc'], json_decode($res->getBody()->getContents(), true));
        } catch (GuzzleException $e) {
            $this->fail('GuzzleException: ' . $e->getMessage());
        }
    }

    public function testDeletePatientsWrongURL(): void
    {
        try {
            $res = $this->client->request('DELETE', 'http://localhost:8000/patients/1/metrics');
            $this->assertEquals('404', $res->getStatusCode());
        } catch (GuzzleException $e) {
            $this->assertEquals(400, $e->getCode());
        }
    }
}