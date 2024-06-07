<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Patient
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property \Illuminate\Support\Carbon $birthdate
 * @property int $age
 * @property string $age_type
 */
class Patient extends Model
{
    protected $table = 'patients';

    protected $casts = [
        'birthdate' => 'datetime',
    ];
}
