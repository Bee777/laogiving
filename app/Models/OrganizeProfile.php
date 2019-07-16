<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizeProfile extends Model
{
    protected $dates = ['registration_date'];

    public static function IncreaseViews($id): void
    {
        $c = self::find($id);
        if (isset($c)) {
            $c->timestamps = false;
            ++$c->view_count;
            $c->save();
        }
    }
}
