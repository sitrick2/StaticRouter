<?php

namespace StaticRouter\Controllers;

use StaticRouter\IRequest;

class PatientsMetricsController
{
    public function index(IRequest $request, $patientId)
    {
        return 'got to index for patient '.$patientId;
    }

    public function get(IRequest $request, $patient_id, $metrics_id)
    {
        return json_encode(['patient_id' => $patient_id, 'metrics_id' => $metrics_id]);
    }

    public function create(IRequest $request, $patient_id)
    {
        return json_encode(['patient_id' => $patient_id, 'request_body' => $request->getBody()]);
    }

    public function update(IRequest $request, $patient_id, $metrics_id)
    {
        return json_encode([
            'patient_id' => $patient_id,
            'metrics_id' => $metrics_id,
            'request_body' => $request->getBody()
        ]);
    }

    public function delete(IRequest $request, $patient_id, $metrics_id)
    {
        return json_encode(['patient_id' => $patient_id, 'metrics_id' => $metrics_id]);
    }
}