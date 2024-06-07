<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePatientRequest;
use App\Services\CreatePatientService;
use App\Services\ReadPatientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PatientController
{
    /**
     * @param CreatePatientRequest $request
     * @param CreatePatientService $createPatientService
     * @return void
     * @throws \Exception
     */
    public function createPatient(
        CreatePatientRequest $request,
        CreatePatientService $createPatientService
    ): void
    {
        try {
            DB::beginTransaction();
            $createPatientService->create($request->all());
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @param ReadPatientService $readPatientService
     * @return JsonResponse
     */
    public function getPatientsList(ReadPatientService $readPatientService): JsonResponse
    {
        return \response()->json($readPatientService->getPatientsList());
    }
}
