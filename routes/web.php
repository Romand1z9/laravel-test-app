<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;

Route::get('/', function () {
    return view('welcome');
});

Route::group(
    [
        'prefix' => 'patient'
    ],
    function() {
        Route::post('create', [PatientController::class, 'createPatient']);
        Route::get('list', [PatientController::class, 'getPatientsList']);
    }
);
