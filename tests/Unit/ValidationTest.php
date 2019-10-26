<?php

use PHPUnit\Framework\TestCase;
use StaticRouter\Validation;

class ValidationTest extends TestCase {

    private $router;

    public function testFormatRoute() :void
    {
        $testRoutes = ['/patients', '/patients/'];
        $expectedResults = ['/patients', '/patients'];
        //@TODO: handle '/patients/2/metrics'
        $counter = 0;
        while ($counter < count($testRoutes)){
            $result = Validation::formatRoute($testRoutes[$counter]);
            $this->assertEquals($expectedResults[$counter], $result);
            $counter++;
        }
    }

    public function testRouteMatchesURI() :void
    {
        $this->assertEquals(Validation::routeMatchesURI('test', 'test'), ['test' => '']);
        $this->assertFalse(Validation::routeMatchesURI('test', 'fail'));
        $this->assertFalse(Validation::routeMatchesURI('test', 'test/1'));
        $this->assertFalse(Validation::routeMatchesURI('Test', 'test'));
        $this->assertEquals(Validation::routeMatchesURI('test', 'test/'), ['test' => '']);
        $this->assertEquals(Validation::routeMatchesURI('test', '/test'), ['test' => '']);
        $this->assertEquals(Validation::routeMatchesURI('test/{id}', '/test/1'), ['test' => '1']);
        $this->assertEquals(Validation::routeMatchesURI('test/{id}/metrics', '/test/1/metrics'), ['test' => '1', 'metrics' => '']);
        $this->assertEquals(Validation::routeMatchesURI('test/{id}/metrics/{id}', '/test/1/metrics/1'), ['test' => '1', 'metrics' => '1']);
        $this->assertFalse(Validation::routeMatchesURI('test/{id}/metrics', '/test/1/topics'));
        $this->assertFalse(Validation::routeMatchesURI('test/{id}/metrics/{id}', '/test/1/topics/2'));
        $this->assertFalse(Validation::routeMatchesURI('test/metrics', '/test/1'));
        $this->assertEquals(Validation::routeMatchesURI('test/metrics', '/test/metrics'), ['test.metrics' => '']);
        $this->assertEquals(Validation::routeMatchesURI('/patients/{id}/metrics/{uuid}', '/patients/2/metrics/abc'), ['patients' => '2', 'metrics' => 'abc']);
        $this->assertEquals(Validation::routeMatchesURI('/patients/metrics/test', '/patients/metrics/test'), ['patients.metrics.test' => '']);
    }

    public function testRequestTypeMatchesRESTFunction() :void
    {
        $this->assertTrue(Validation::requestTypeMatchesRESTFunction('get', 'get'));
        $this->assertTrue(Validation::requestTypeMatchesRESTFunction('test', 'TEST'));
        $this->assertTrue(Validation::requestTypeMatchesRESTFunction('POST', 'post'));
        $this->assertTrue(Validation::requestTypeMatchesRESTFunction('patCH', 'PATcH'));
        $this->assertTrue(Validation::requestTypeMatchesRESTFunction('Delete', 'delete'));
        $this->assertFalse(Validation::requestTypeMatchesRESTFunction('get', 'post'));
    }

    public function testToCamelCase() :void
    {
        $this->assertEquals('requestMethod', Validation::toCamelCase('REQUEST_METHOD'));
        $this->assertEquals('testCase', Validation::toCamelCase('TEST_CASE'));
        $this->assertEquals('threeWordTest', Validation::toCamelCase('THREE_WORD_TEST'));
        $this->assertEquals('test', Validation::toCamelCase('TEST'));
        $this->assertEquals('testThis', Validation::toCamelCase('TEST THIS'));
    }
}