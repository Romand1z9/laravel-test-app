<?php

namespace App\Services;

use App\Models\Patient;
use Carbon\Carbon;

class CreatePatientService
{
    /**
     * @var PatientsCacheService
     */
    private $patientsCacheService;

    /**
     * @var PatientsQueueService
     */
    private $patientsQueueService;


    /**
     * @param PatientsCacheService $patientsCacheService
     * @param PatientsQueueService $patientsQueueService
     */
    public function __construct(
        PatientsCacheService $patientsCacheService,
        PatientsQueueService $patientsQueueService
    )
    {
        $this->patientsCacheService = $patientsCacheService;
        $this->patientsQueueService = $patientsQueueService;
    }


    /**
     * @param array $data
     * @return void
     */
    public function create(array $data = []): void
    {
        $newPatient = $this->saveNewPatient($data);
        $this->patientsCacheService->addPatientToCache($newPatient);
        $this->patientsQueueService->addPatientInQueue($newPatient);
    }

    /**
     * @param array $data
     * @return Patient
     */
    private function saveNewPatient(array $data = []): Patient
    {
        $newPatient = new Patient();
        $newPatient
            ->fill(
            $data + $this->getAgeInfo($data['birthdate'])
            )
            ->save()
        ;
        return $newPatient;
    }

    /**
     * @param string $birthDate
     * @return array
     */
    private function getAgeInfo(string $birthDate): array
    {
        $birthDate = Carbon::parse($birthDate);
        $now = \now();

        $age = 0;
        $ageType = null;

        $ageInYears = (int)($now->diffInYears($birthDate));
        $ageInMonths = (int)($now->diffInMonths($birthDate));
        $ageInDays = (int)($now->diffInDays($birthDate));

        if ($ageInYears > 0) {
            $age = $ageInYears;
            $ageType = 'years';
        } else if ($ageInMonths > 0) {
            $age = $ageInMonths;
            $ageType = 'months';
        } else if ($ageInDays > 0) {
            $age = $ageInDays;
            $ageType = 'days';
        }

        return [
            'age' => $age,
            'age_type' => $ageType
        ];
    }
}
