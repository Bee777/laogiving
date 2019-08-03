<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class VolunteeringActivityPosition extends Model
{
    public static function saveSkills($positionModel, $skills)
    {
        if (count($skills) > 10) {
            return;
        }
        $skillsModel = $positionModel->skills;
        if (count($skillsModel) > 0) {
            $skillsCount = count($skills);
            $diff = count($skillsModel) - $skillsCount;
            if ($diff >= 0) {
                foreach ($skills as $key => $item) {
                    $skillModel = $skillsModel[$key];
                    $skillModel->skill_id = $item;
                    $skillModel->save();
                }
                for ($i = 0; $i < $diff; $i++) {
                    if (isset($skillsModel[$skillsCount + $i])) {
                        $itemModel = $skillsModel[$skillsCount + $i];
                        $itemModel->delete();
                    } else {
                        Log::info("#skill-detail-delete# diff: $diff, i: $i, position id: $positionModel->id");
                    }
                }
            } else {
                foreach ($skills as $key => $item) {
                    if (isset($skillsModel[$key])) {
                        $itemModel = $skillsModel[$key];
                        $itemModel->skill_id = $item;
                        $itemModel->save();
                    } else {
                        $itemModel = new VolunteeringActivityPositionSkill();
                        $itemModel->skill_id = $item;
                        $positionModel->skills()->save($itemModel);
                    }
                }
            }
        } else {
            foreach ($skills as $key => $item) {
                $itemModel = new VolunteeringActivityPositionSkill();
                $itemModel->skill_id = $item;
                $positionModel->skills()->save($itemModel);
            }
        }
    }

    public static function saveSuitables($positionModel, $suitables)
    {
        if (count($suitables) > 10) {
            return;
        }
        $suitablesModel = $positionModel->suitables;
        if (count($suitablesModel) > 0) {
            $suitablesCount = count($suitables);
            $diff = count($suitablesModel) - $suitablesCount;
            if ($diff >= 0) {
                foreach ($suitables as $key => $item) {
                    $skillModel = $suitablesModel[$key];
                    $skillModel->suitable_id = $item;
                    $skillModel->save();
                }
                for ($i = 0; $i < $diff; $i++) {
                    if (isset($suitablesModel[$suitablesCount + $i])) {
                        $itemModel = $suitablesModel[$suitablesCount + $i];
                        $itemModel->delete();
                    } else {
                        Log::info("#suitable-detail-delete# diff: $diff, i: $i, position id: $positionModel->id");
                    }
                }
            } else {
                foreach ($suitables as $key => $item) {
                    if (isset($suitablesModel[$key])) {
                        $itemModel = $suitablesModel[$key];
                        $itemModel->suitable_id = $item;
                        $itemModel->save();
                    } else {
                        $itemModel = new VolunteeringActivityPositionSuitable();
                        $itemModel->suitable_id = $item;
                        $positionModel->suitables()->save($itemModel);
                    }
                }
            }
        } else {
            foreach ($suitables as $key => $item) {
                $itemModel = new VolunteeringActivityPositionSuitable();
                $itemModel->suitable_id = $item;
                $positionModel->suitables()->save($itemModel);
            }
        }
    }

    public function skills()
    {
        return $this->hasMany(VolunteeringActivityPositionSkill::class, 'volunteering_activity_position_id');
    }

    public function suitables()
    {
        return $this->hasMany(VolunteeringActivityPositionSuitable::class, 'volunteering_activity_position_id');
    }
}
