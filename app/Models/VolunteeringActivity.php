<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteeringActivity extends Model
{
    protected $dates = ['start_date', 'end_date', 'deadline_sign_ups_date'];

}
