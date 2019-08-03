<?php

namespace App\Models;

use App\Http\Controllers\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    //
    public static function getSkills(string $limit)
    {
        $mLimit = Helpers::isNumber($limit) ? $limit : 3;
        if ($limit === 'all') {
            $skills = self::orderBy('id', 'asc')->get();
        } else {
            $skills = self::limit($mLimit)->orderBy('id', 'asc')->get();
        }
        return $skills;
    }
}
