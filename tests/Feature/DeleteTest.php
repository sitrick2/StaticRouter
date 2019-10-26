<?php

namespace StaticRouter\Tests\Feature;

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
            $res = $this->client->request('DELETE', 'http://localhost:8000/patients/1');
            $this->assertEquals($res->getStatusCode(), '200');
            $this->assertEquals('1', $res->getBody()->getContents());
        } catch (GuzzleException $e) {
            $this->fail('GuzzleException: ' . $e->getMessage());
        }
    }

    public function testDeletePatientsWrongURL(): void
    {
        try {
            $res = $this->client->request('DELETE', 'http://localhost:8000/patients', [
                'json' => ['test' => 1]
            ]);
            $this->assertEquals($res->getStatusCode(), '404');
        } catch (GuzzleException $e) {
            $this->assertEquals(400, $e->getCode());
        }
    }
}