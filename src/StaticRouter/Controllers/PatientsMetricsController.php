<?php

namespace StaticRouter\Controllers;

use StaticRouter\IRequest;

class PatientsMetricsController
{
    public function index($patientId)
    {
        return 'got to index for patient '.$patientId;
    }

    public function get($patient_id, $metrics_id)
    {
        return ['patient_id' => $patient_id, 'metrics_id' => $metrics_id];
    }

    public function create(IRequest $request, $patient_id)
    {
        return ['patient_id' => $patient_id, 'request_body' => $request->getBody()];
    }

    public function update(IRequest $request, $patient_id, $metrics_id)
    {
        return ['patient_id' => $patient_id, 'metrics_id' => $metrics_id, 'request_body' => $request->getBody()];
    }

    public function delete($patient_id, $metrics_id)
    {
        return ['patient_id' => $patient_id, 'metrics_id' => $metrics_id];
    }
}