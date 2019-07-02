<?php

namespace App\Models;

use App\Http\Controllers\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;

class Suitable extends Model
{
    //
    public static function getSuitables(string $limit)
    {
        $mLimit = Helpers::isNumber($limit) ? $limit : 3;
        if ($limit === 'all') {
            $items = self::orderBy('id', 'asc')->get();
        } else {
            $items = self::limit($mLimit)->orderBy('id', 'asc')->get();
        }
        return $items;
    }
}
