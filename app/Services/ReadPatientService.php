<?php

namespace App\Services;

use App\Models\Patient;
use Illuminate\Support\Collection;

class ReadPatientService
{

    /**
     * @var PatientsCacheService
     */
    private $patientsCacheService;

    /**
     * @param PatientsCacheService $patientsCacheService
     */
    public function __construct(PatientsCacheService $patientsCacheService)
    {
        $this->patientsCacheService = $patientsCacheService;
    }

    /**
     * @return array|Patient[]
     */
    public function getPatientsList(): array
    {
        $patients = $this->getPatientsListFromCache();
        $patients = $patients->isNotEmpty()
            ? $patients
            : $this->getPatientsListFromDB()
        ;

        return $patients->map(function (Patient $patient) {
            return [
                'id' => $patient->id,
                'name' => "$patient->first_name $patient->last_name",
                'birthDate' => $patient->birthdate->format('d.m.Y'),
                'age' => "$patient->age $patient->age_type"
            ];
        });
    }

    /**
     * @return Collection|Patient[]
     */
    private function getPatientsListFromCache(): Collection
    {
        return $this->patientsCacheService->getPatientsList();
    }

    /**
     * @return Collection|Patient[]
     */
    private function getPatientsListFromDB(): Collection
    {
        return Patient::all();
    }
}
