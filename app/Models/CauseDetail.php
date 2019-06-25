<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class CauseDetail extends Model
{

    public function cause()
    {
        return $this->belongsTo(Cause::class);
    }

    public static function list($type, $id, $limit = 0)
    {
        if ($limit <= 0) {
            return self::where('type', $type)->where('related_id', $id)->get();
        }
        return self::where('type', $type)->where('related_id', $id)->limit($limit)->get();
    }

    public static function saveUser($user, $causes): void
    {
        self::saveData($user->id, 'user', $causes);
    }

    protected static function saveData($id, $type, $causes): void
    {
        if (count($causes) <= 0) {
            self::where('related_id', $id)->where('type', $type)->delete();
            return;
        }
        $causesModel = self::where('related_id', $id)->where('type', $type)->get();
        if (count($causesModel) > 0) {
            $causeCount = count($causes);
            $diff = count($causesModel) - $causeCount;
            if ($diff >= 0) {
                foreach ($causes as $key => $cause) {
                    $causeModel = $causesModel[$key];
                    $causeModel->cause_id = $cause;
                    $causeModel->save();
                }
                for ($i = 0; $i < $diff; $i++) {
                    if (isset($causesModel[$causeCount + $i])) {
                        $causesModel[$causeCount + $i]->delete();
                    } else {
                        Log::info("#causes-detail-delete# diff: $diff, i: $i, type: $type, id: $id");
                    }
                }
            } else {
                foreach ($causes as $key => $cause) {
                    $causeModel = $causesModel[$key] ?? new self();
                    $causeModel->related_id = $id;
                    $causeModel->type = $type;
                    $causeModel->cause_id = $cause;
                    $causeModel->save();
                }
            }
        } else {
            foreach ($causes as $cause) {
                $existCauseModel = Cause::find($cause);
                if (isset($existCauseModel)) {
                    $causeModel = new self();
                    $causeModel->cause_id = $cause;
                    $causeModel->related_id = $id;
                    $causeModel->type = $type;
                    $causeModel->save();
                }
            }
        }

    }
}
