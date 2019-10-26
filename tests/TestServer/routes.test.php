<?php

require __DIR__ . '\..\..\vendor\autoload.php';

use StaticRouter\StaticRouter;
use StaticRouter\RequestResolver;

function routes()
{
    StaticRouter::get('/patients', '\TestControllers\PatientsController@index');
    StaticRouter::get('/patients/{patient_id}', '\TestControllers\PatientsController@get');
    StaticRouter::post('/patients', '\TestControllers\PatientsController@create');
    StaticRouter::patch('/patients/{patient_id}', '\TestControllers\PatientsController@update');
    StaticRouter::delete('/patients/{patient_id}', '\TestControllers\PatientsController@delete');

    StaticRouter::get('/patients/{patient_id}/metrics', '\TestControllers\PatientsMetricsController@index');
    StaticRouter::get('/patients/{patient_id}/metrics/{metric_id}', '\TestControllers\PatientsMetricsController@get');
    StaticRouter::post('/patients/{patient_id}/metrics', '\TestControllers\PatientsMetricsController@create');
    StaticRouter::patch('/patients/{patient_id}/metrics/{metric_id}', '\TestControllers\PatientsMetricsController@update');
    StaticRouter::delete('/patients/{patient_id}/metrics/{metric_id}', '\TestControllers\PatientsMetricsController@delete');

    StaticRouter::get('/', function() {
        return "Hello World";
    });

    StaticRouter::get('/test/{test_id}', function() {
        return 'found the end';
    });

    RequestResolver::wrapUp();
}