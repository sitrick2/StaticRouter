<?php

namespace StaticRouter\Tests\Feature;

use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;

class PatchTest extends TestCase {

    protected $client;
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->client = new \GuzzleHttp\Client();
    }

    public function testPatientUpdateWithJSON(): void
    {
        try {
            $res = $this->client->request('PATCH', 'http://localhost:8000/patients/1', [
                'json' => ['test' => 1]
            ]);
            $this->assertEquals($res->getStatusCode(), '200');
            $this->assertEquals(['body' => ['test' => 1], 'patient_id' => '1'], json_decode($res->getBody()->getContents(), true));
        } catch (GuzzleException $e) {
            $this->fail('GuzzleException: ' . $e->getMessage());
        }
    }

    public function testPatientUpdateWithUrlEncoded(): void
    {
        try {
            $res = $this->client->request('PATCH', 'http://localhost:8000/patients/1', [
                'form_params' => ['test' => 1]
            ]);
            $this->assertEquals($res->getStatusCode(), '200');
            $this->assertEquals(['body' => ['test' => 1], 'patient_id' => '1'], json_decode($res->getBody()->getContents(), true));
        } catch (GuzzleException $e) {
            $this->fail('GuzzleException: ' . $e->getMessage());
        }
    }

    public function testPatientsWrongURL(): void
    {
        try {
            $res = $this->client->request('PATCH', 'http://localhost:8000/patients', [
                'json' => ['test' => 1]
            ]);
            $this->assertEquals($res->getStatusCode(), '400');
        } catch (GuzzleException $e) {
            $this->assertEquals(400, $e->getCode());
        }
    }
}