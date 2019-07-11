<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class VolunteeringActivity extends Model
{
    protected $dates = ['start_date', 'end_date', 'deadline_sign_ups_date'];


    public static function savePositions($activity, $positions)
    {
        $positionsModel = $activity->positions;
        if (count($positionsModel) > 0) {
            $positionsCount = count($positions);
            $diff = count($positionsModel) - $positionsCount;
            if ($diff >= 0) {
                foreach ($positions as $key => $item) {
                    $item = json_decode($item);
                    $positionModel = $positionsModel[$key];
                    $positionModel->title = $item->position_title;
                    $positionModel->vacancies = $item->vacancies;
                    $positionModel->minimum_age = empty($item->minimum_age) ? null : $item->minimum_age;
                    $positionModel->key_responsibilities_impact = $item->key_responsibilities;
                    $positionModel->save();
                    VolunteeringActivityPosition::saveSkills($positionModel, $item->position_skills);
                    VolunteeringActivityPosition::saveSuitables($positionModel, $item->position_suitables);
                }
                for ($i = 0; $i < $diff; $i++) {
                    if (isset($positionsModel[$positionsCount + $i])) {
                        $positionModel = $positionsModel[$positionsCount + $i];
                        $positionModel->delete();
                    } else {
                        Log::info("#position-detail-delete# diff: $diff, i: $i, activity id: $activity->id");
                    }
                }
            } else {
                foreach ($positions as $key => $item) {
                    $item = json_decode($item);
                    if (isset($positionsModel[$key])) {
                        $itemModel = $positionsModel[$key];
                        $itemModel->title = $item->position_title;
                        $itemModel->vacancies = $item->vacancies;
                        $itemModel->minimum_age = empty($item->minimum_age) ? null : $item->minimum_age;
                        $itemModel->key_responsibilities_impact = $item->key_responsibilities;
                        $itemModel->save();
                        VolunteeringActivityPosition::saveSkills($itemModel, $item->position_skills);
                        VolunteeringActivityPosition::saveSuitables($itemModel, $item->position_suitables);
                    } else {
                        $itemModel = new VolunteeringActivityPosition();
                        $itemModel->title = $item->position_title;
                        $itemModel->vacancies = $item->vacancies;
                        $itemModel->minimum_age = empty($item->minimum_age) ? null : $item->minimum_age;
                        $itemModel->key_responsibilities_impact = $item->key_responsibilities;
                        $itemModel->volunteering_activity_id = $activity->id;
                        $itemModel->save();
                        VolunteeringActivityPosition::saveSkills($itemModel, $item->position_skills);
                        VolunteeringActivityPosition::saveSuitables($itemModel, $item->position_suitables);
                    }
                }
            }
        } else {
            foreach ($positions as $key => $item) {
                $item = json_decode($item);
                $itemModel = new VolunteeringActivityPosition();
                $itemModel->title = $item->position_title;
                $itemModel->vacancies = $item->vacancies;
                $itemModel->minimum_age = empty($item->minimum_age) ? null : $item->minimum_age;
                $itemModel->key_responsibilities_impact = $item->key_responsibilities;
                $itemModel->volunteering_activity_id = $activity->id;
                $itemModel->save();
                VolunteeringActivityPosition::saveSkills($itemModel, $item->position_skills);
                VolunteeringActivityPosition::saveSuitables($itemModel, $item->position_suitables);
            }
        }
    }

    public function positions()
    {
        return $this->hasMany(VolunteeringActivityPosition::class, 'volunteering_activity_id');
    }

    public function positionsMap()
    {
        $mPositions = [
            [
                'collapsed' => false,
                'id' => 0,
                'position_title' => '',
                'vacancies' => '',
                'minimum_age' => '',
                'position_skills' => [],
                'position_suitables' => [],
                'key_responsibilities' => '',
                'active_opportunity' => 0,
                'total_vacancies_left' => 0,
                'total_pending' => 0,
                'confirm_users' => [],
                'validated' => json_decode(json_encode([], JSON_FORCE_OBJECT)),
            ]
        ];
        $positions = $this->positions;
        if (count($positions) > 0) {
            $mPositions = [];
        }
        foreach ($positions as $position) {
            $active_vacancies = self::getPositionVacanciesActive($position->volunteering_activity_id, $position->id);
            $mPositions[] = [
                'collapsed' => false,
                'id' => $position->id,
                'position_title' => $position->title,
                'vacancies' => $position->vacancies,
                'minimum_age' => $position->minimum_age,
                'position_skills' => $position->skills->pluck('skill_id'),
                'position_suitables' => $position->suitables->pluck('suitable_id'),
                'key_responsibilities' => $position->key_responsibilities_impact,
                'active_opportunity' => $active_vacancies,
                'total_vacancies_left' => $position->vacancies - $active_vacancies,
                'total_pending' => VolunteerSignUpActivity::getSignUpPositionPendingCount($position->volunteering_activity_id, $position->id),
                'confirm_users' => VolunteerSignUpActivity::getSignUpPositionUsers($position->volunteering_activity_id, $position->id),
                'validated' => json_decode(json_encode([], JSON_FORCE_OBJECT)),
            ];
        }
        unset($this->positions);
        return $mPositions;
    }

    public static function getPositionVacanciesActive($activity_id, $position_id)
    {
        return VolunteerSignUpActivity::getSignUpPositionCount($activity_id, $position_id);
    }
}
