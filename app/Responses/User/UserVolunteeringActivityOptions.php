<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 2/25/2019
 * Time: 11:03 PM
 */

namespace App\Responses\User;

use App\Http\Controllers\Helpers\Helpers;
use App\Models\Cause;
use App\Models\CauseDetail;
use App\Models\Media;
use App\Models\Skill;
use App\Models\Suitable;
use App\Models\VolunteeringActivity;
use App\User;
use Illuminate\Contracts\Support\Responsable;

class UserVolunteeringActivityOptions implements Responsable
{

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        $data = [];
        if (Helpers::isAjax($request)) {
            $user = $request->user();
            if ($user->isUser('organize')) {
                $data['volunteering'] = $this->transformUserActivity($user, $request->activity_id);
            }
            $data['causes'] = Cause::getCauses('all');
            $data['skills'] = Skill::getSkills('all');
            $data['suitables'] = Suitable::getSuitables('all');
            return response()->json(['success' => true, 'data' => $data]);
        }
    }

    public function transformUserActivity(User $user, $id)
    {
        $activity = null;
        if (isset($user)) {
            $activity = VolunteeringActivity::find($id);
            if (isset($activity)) {
                $activity->activity_causes = CauseDetail::list('activity', $activity->id)->pluck('cause_id');
                $activity_causes = CauseDetail::list('activity', $activity->id);
                $activity_causes->map(function ($item) {
                    $item->cause_data = $item->cause;
                    return $item;
                });
                $activity->activity_causes_display = $activity_causes->pluck('cause_data');

                $activityMediaVideo = Media::single('activity', 'youtube', $activity->id);
                $activity->video_media = $activityMediaVideo ?? ['validated' => '', 'url' => ''];
                $activityMediaImages = Media::list('activity', 'image', $activity->id);
                if (count($activityMediaImages) > 0) {
                    #set step 1
                    $activity->step = 1;
                    $activity->images_media = $activityMediaImages;
                } else {
                    $activity->images_media = [
                        [
                            'image_base64' => '',
                            'image' => null,
                            'validated' => '',
                            'removable' => false
                        ]
                    ];
                }

                $days_of_week = [];
                if ($activity->weekday === 'yes') {
                    $days_of_week[] = 'WEEKDAY';
                }
                if ($activity->weekend === 'yes') {
                    $days_of_week[] = 'WEEKEND';
                }
                if (count($days_of_week) > 0) {
                    #set step 2
                    $activity->step = 2;
                }
                $activity->days_of_week = $days_of_week;

                $activity->positions = $activity->positions;
                if (count($activity->positions) > 0) {
                    #set step 3
                    $activity->step = 3;
                }
                $activity->positions = $activity->positionsMap();

                if (!empty($activity->contact_title)) {
                    #set step 4
                    $activity->step = 4;
                }
            }
        }
        return $activity;
    }
}
