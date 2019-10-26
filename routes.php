<?php

require __DIR__ . '/vendor/autoload.php';

use StaticRouter\StaticRouter;

function routes()
{
    StaticRouter::get('/patients', '\StaticRouter\Controllers\PatientsController@index');
    StaticRouter::get('/patients/{patient_id}', '\StaticRouter\Controllers\PatientsController@get');
    StaticRouter::post('/patients', '\StaticRouter\Controllers\PatientsController@create');
    StaticRouter::patch('/patients/{patient_id}', '\StaticRouter\Controllers\PatientsController@update');
    StaticRouter::delete('/patients/{patient_id}', '\StaticRouter\Controllers\PatientsController@delete');

    StaticRouter::get('/patients/{patient_id}/metrics', '\StaticRouter\Controllers\PatientsMetricsController@index');
    StaticRouter::get('/patients/{patient_id}/metrics/{metric_id}', '\StaticRouter\Controllers\PatientsMetricsController@get');
    StaticRouter::post('/patients/{patient_id}/metrics', '\StaticRouter\Controllers\PatientsMetricsController@create');
    StaticRouter::patch('/patients/{patient_id}/metrics/{metric_id}', '\StaticRouter\Controllers\PatientsMetricsController@update');
    StaticRouter::delete('/patients/{patient_id}/metrics/{metric_id}', '\StaticRouter\Controllers\PatientsMetricsController@delete');


    if (!isset($_SESSION['200'])) {

        if (isset($_SESSION['400'])) {
            header($_SESSION['400']);
            echo $_SESSION['400'];
            try {
                exit;
            } catch (Exception $e) {
                exit;
            }

        }

        if (isset($_SESSION['404'])) {
            header($_SESSION['404']);
            echo $_SESSION['404'];
            try {
                exit;
            } catch (Exception $e) {
                exit;
            }
        }

        if (isset($_SESSION['405'])) {
            echo $_SESSION['405'];
            header($_SESSION['405']);
            try {
                exit;
            } catch (Exception $e) {
                exit;
            }

        }
    } else {
        exit;
    }
}