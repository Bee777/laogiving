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
use App\Models\VolunteeringActivity;
use App\Models\VolunteerSignUpActivity;
use App\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;

class UserVolunteeringActivityManager implements Responsable
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
                $data['volunteering'] = $this->transformUserActivity($user, $request->id);
                $data['volunteering_sign_ups'] = null;
                $data['volunteering_attendance'] = null;
                if (!isset($data['volunteering'])) {
                    return response()->json(['success' => false, 'data' => $data]);
                }

                $paginateLimit = ($request->exists('limit') && !empty($request->get('limit'))) ? $request->get('limit') : 10;
                $paginateLimit = Helpers::isNumber($paginateLimit) ? $paginateLimit : 10;
                $text = $request->get('q');


                if ((int)$request->tab === 0) {

                    $data['volunteering_sign_ups'] = VolunteerSignUpActivity::select('volunteer_sign_up_activities.*', DB::raw('(select count(null)) as checked'), DB::raw('(select count(null)) as show_other_response'))->where('volunteering_activity_id', $data['volunteering']->id)->with(['user' => function ($query) {
                        $query->select('users.*', 'volunteer_profiles.gender');
                        $query->leftJoin('volunteer_profiles', 'volunteer_profiles.user_id', 'users.id');
                    }])->orderBy('id', 'desc');
                    #paginate
                    $data['volunteering_sign_ups'] = $data['volunteering_sign_ups']->paginate($paginateLimit);
                    $data['volunteering_sign_ups']->appends(['limit' => $paginateLimit, 'q' => $text]);

                } else {
                    $data['volunteering_attendance'] = VolunteerSignUpActivity::select('volunteer_sign_up_activities.*', 'volunteer_sign_up_activities.hour_per_volunteer as hours', DB::raw('(select count(null)) as checked, (select count(null)) as old_checked'),
                        DB::raw('(select count(null)) as validated'))->where('volunteering_activity_id', $data['volunteering']->id)->with(['user' => function ($query) {
                        $query->select('users.*', 'volunteer_profiles.gender');
                        $query->leftJoin('volunteer_profiles', 'volunteer_profiles.user_id', 'users.id');
                    }])->whereIn('status', ['confirm', 'checkin'])->orderBy('id', 'desc');
                    #paginate
                    $data['volunteering_attendance'] = $data['volunteering_attendance']->paginate($paginateLimit);
                    $data['volunteering_attendance']->appends(['limit' => $paginateLimit, 'q' => $text]);
                }
            }
            return response()->json(['success' => true, 'data' => $data]);
        }
    }

    public function transformUserActivity(User $user, $id)
    {
        $activity = null;
        if (isset($user)) {
            $activity = VolunteeringActivity::find($id);
            if (isset($activity)) {
                $activity->start_date_formatted_number = Helpers::toFormatDateString($activity->start_date, 'd M Y');
                $activity->end_date_formatted_number = Helpers::toFormatDateString($activity->end_date, 'd M Y');
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
