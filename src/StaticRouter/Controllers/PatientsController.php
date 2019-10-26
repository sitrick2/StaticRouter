<?php

namespace StaticRouter\Controllers;

use StaticRouter\IRequest;

class PatientsController
{
    public function index(IRequest $request)
    {
        return 'got to patient Data';
    }

    public function get(IRequest $request, $patientId)
    {
        return $patientId;
    }

    public function create(IRequest $request)
    {
        return json_encode(['body' => $request->getBody()]);
    }

    public function update(IRequest $request, $patient_id)
    {
        return json_encode(['body' => $request->getBody(), 'patient_id' => $patient_id]);
    }

    public function delete(IRequest $request, $patient_id)
    {
        return $patient_id;
    }
}