<?php

namespace App\Services;

use App\Models\Patient;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class PatientsCacheService
{
    private const PATIENTS_CACHE_KEY = 'patients';
    private const CACHE_DURATION_IN_MINUTES = 5;

    /**
     * @param Patient $patient
     * @return void
     */
    public function addPatientToCache(Patient $newPatient): void
    {
        $patients = $this->getPatientsList();
        $patients->add($newPatient);

        $now = \now();

        Cache::set(
            self::PATIENTS_CACHE_KEY,
            json_encode($patients->toArray()),
            $now->diffAsDateInterval($now->addMinutes(self::CACHE_DURATION_IN_MINUTES))
        );
    }

    /**
     * @return Collection|Patient[]
     */
    public function getPatientsList(): Collection
    {
        $patientList = json_decode(
            Cache::get(self::PATIENTS_CACHE_KEY, '[]')
        );
        $patientList = array_map(function (object $item) {
            return (new Patient())
                ->fill($item);
        },
            $patientList
        );

        return \collect($patientList);
    }
}
