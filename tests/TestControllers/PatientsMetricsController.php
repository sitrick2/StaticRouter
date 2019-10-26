<?php

namespace TestControllers;

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
        return json_encode(['patient_id' => $patient_id, 'body' => $request->getBody()]);
    }

    public function update(IRequest $request, $patient_id, $metrics_id)
    {
        return json_encode([
            'body' => $request->getBody(),
            'patient_id' => $patient_id,
            'metrics_id' => $metrics_id
        ]);
    }

    public function delete(IRequest $request, $patient_id, $metrics_id)
    {
        return json_encode(['patient_id' => $patient_id, 'metrics_id' => $metrics_id]);
    }
}