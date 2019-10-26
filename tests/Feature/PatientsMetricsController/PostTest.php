<?php

namespace StaticRouter\Tests\Feature\PatientsMetricsController;

use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class PostTest extends TestCase {

    protected $client;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->client = new Client();
    }

    public function testPatientCreateWithUrlEncoded(): void
    {
        try {
            $res = $this->client->request('POST', 'http://localhost:8000/patients/1/metrics', [
                'form_params' => ['test' => 1]
            ]);
            $this->assertEquals($res->getStatusCode(), '200');
            $this->assertEquals(['body' => ['test' => 1], 'patient_id' => '1'], json_decode($res->getBody()->getContents(), true));
        } catch (GuzzleException $e) {
            $this->fail('GuzzleException: ' . $e->getMessage());
        }
    }

    public function testPatientCreateWithJSON(): void
    {
        try {
            $res = $this->client->request('POST', 'http://localhost:8000/patients/1/metrics', [
                'json' => ['test' => 1]
            ]);
            $this->assertEquals($res->getStatusCode(), '200');
            $this->assertEquals(['body' => ['test' => 1], 'patient_id' => 1], json_decode($res->getBody()->getContents(), true));
        } catch (GuzzleException $e) {
            $this->fail('GuzzleException: ' . $e->getMessage());
        }
    }

    public function testPatientsWrongURL(): void
    {
        try {
            $res = $this->client->request('POST', 'http://localhost:8000/patients/1/metrics/1', [
                'json' => ['test' => 1]
            ]);
            $this->assertEquals($res->getStatusCode(), '404');
        } catch (GuzzleException $e) {
            $this->assertEquals(404, $e->getCode());
        }
    }
}