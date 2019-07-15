<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 2/25/2019
 * Time: 11:03 PM
 */

namespace App\Responses\User;

use App\Http\Controllers\Helpers\Helpers;
use App\Models\Media;
use App\Models\UserSaved;
use App\Models\VolunteeringActivity;
use App\Traits\UserRoleTrait;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserSavedBookmarkResponse implements Responsable
{
    use UserRoleTrait;

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        if (Helpers::isAjax($request)) {
            $paginateLimit = ($request->exists('limit') && !empty($request->get('limit'))) ? $request->get('limit') : 6;
            $paginateLimit = Helpers::isNumber($paginateLimit) ? $paginateLimit : 6;
            $text = $request->get('q');
            return $this->getVolunteerings($request, $text, $paginateLimit);
        }
    }

    public function getVolunteerings(Request $request, $text, $paginateLimit)
    {
        $user = $request->user('api');
        $user_saved_fields = ['user_saveds.type as post_type', 'user_saveds.id as saved_id'];
        $activity_fields = [
            #organize
            'users.id as user_id',
            'users.image',
            'users.name as user_name',
            'users.email as user_email',
            'users.name as about',
            'users.name as display_name',
            #organize
            #activity
            'users.name as organize',
            'volunteering_activities.name',
            'volunteering_activities.description',
            'volunteering_activities.duration',
            'volunteering_activities.start_date',
            'volunteering_activities.end_date',
            'volunteering_activities.deadline_sign_ups_date',
            'volunteering_activities.town',
            'volunteering_activities.block_street',
            'volunteering_activities.building_name',
            'volunteering_activities.building_unit_number',
            'volunteering_activities.created_at',
            'volunteering_activities.updated_at'
            #activity
        ];

        $activity_fields_merge = [
            'volunteering_activities.id',
            'volunteering_activities.id as activity_id',
            'volunteering_activities.frequency',
            'volunteering_activities.weekday',
            'volunteering_activities.weekend',
            'volunteering_activities.status'
        ];

        $organize_fields = [
            'users.id as user_id',
            'users.image',
            'users.name as user_name',
            'users.email as user_email',
            'organize_profiles.about',
            'organize_profiles.display_name'
        ];
        #activity
        $merge_activity_fields = array_merge($user_saved_fields, $activity_fields, $activity_fields_merge);
        $activity_union_fields = count($merge_activity_fields) - 1;
        $union_all_activity_fields = [];
        for ($i = 0, $max = $activity_union_fields; $i < $max; $i++) {
            $union_all_activity_fields[] = DB::raw("NULL AS UNION_{$i}_COLUMN");
        }

        #organize
        $merge_organize_fields = array_merge($user_saved_fields, $organize_fields);
        $organize_union_fields = count($merge_organize_fields) - 1;
        $union_all_organize_fields = [];
        for ($i = 0, $max = $organize_union_fields; $i < $max; $i++) {
            $union_all_organize_fields[] = DB::raw("NULL AS UNION_{$i}_COLUMN");
        }

        $request->request->add(['fields' => $activity_fields]);


        $dataFilter = [];
        $post_type = $request->get('post_type');
        $causes = array_filter(explode(',', $request->causes));
        $count = [];
        $count['volunteering'] = 0;
        $count['organizations_or_groups'] = 0;

        $dataActivities = UserSaved::select(array_merge($merge_activity_fields, $union_all_organize_fields))
            ->join('volunteering_activities', 'volunteering_activities.id', 'user_saveds.post_id')
            ->join('users', 'users.id', 'volunteering_activities.user_id')
            ->join('user_types', 'user_types.user_id', 'users.id')
            ->where('user_types.type_user_id', $this->getTypeUserId('organize'))
            ->where('volunteering_activities.status', 'live')
            ->where('users.status', 'approved')
            ->where('user_saveds.type', 'activity')
            ->where('user_saveds.user_id', $user->id);

        $dataOrganizations = UserSaved::select(array_merge($merge_organize_fields, $union_all_activity_fields))
            ->join('users', 'users.id', 'user_saveds.post_id')
            ->join('user_types', 'user_types.user_id', 'users.id')
            ->join('organize_profiles', 'organize_profiles.user_id', 'users.id')
            ->where('organize_profiles.visibility', 'visible')
            ->where('user_types.type_user_id', $this->getTypeUserId('organize'))
            ->where('users.status', 'approved')
            ->where('user_saveds.type', 'organize')
            ->where('user_saveds.user_id', $user->id);

        #filter by causes organize
        if (count($causes) > 0) {
            $dataFilter['causes_organize'] = DB::table('cause_details')->select('related_id')
                ->where('type', 'user')
                ->whereIn('cause_id', $causes)
                ->groupBy('related_id')
                ->havingRaw('count(DISTINCT cause_id) = ' . count($causes))->pluck('related_id')->toArray();
            $dataOrganizations->whereIn('users.id', $dataFilter['causes_organize']);
        }
        #filter by causes activity
        if (count($causes) > 0) {
            $dataFilter['causes'] = DB::table('cause_details')->select('related_id')
                ->where('type', 'activity')
                ->whereIn('cause_id', $causes)
                ->groupBy('related_id')
                ->havingRaw('count(DISTINCT cause_id) = ' . count($causes))->pluck('related_id')->toArray();

            $dataActivities->whereIn('volunteering_activities.id', $dataFilter['causes']);
        }
        #filter by post type
        if ($post_type === 'organizations_or_groups') {
            $data = $dataOrganizations;
        } else if ($post_type === 'volunteering') {
            $data = $dataActivities;
        } else {
            $data = $dataActivities->unionAll($dataOrganizations);
        }
        #count
        $clone = clone $dataActivities;
        $clone = $clone->get();
        $clone = $clone->filter(function ($c) {
            return $c->post_type === 'activity';
        });
        $count['volunteering'] = count($clone);
        $clone = clone $dataOrganizations;
        $count['organizations_or_groups'] = count($clone->get());
        $clone = null;
        #all count
        $total_data = clone $data;
        $total_count = $total_data->get()->count();
        #set data
        $data = $data->orderBy('saved_id', 'desc')->paginate($paginateLimit);
        #map data
        $data->map(function ($activity) {
            $activityMediaVideo = Media::single('activity', 'youtube', $activity->activity_id);
            $activity->video_media = $activityMediaVideo ?? ['validated' => '', 'url' => ''];
            $activityMediaImages = Media::list('activity', 'image', $activity->activity_id);
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
            $activity->days_of_week = $days_of_week;
            $activity->positions = VolunteeringActivity::mapPosition($activity->activity_id ?? 0);

            #date map
            $activity->start_date_formatted = Helpers::toFormatDateString($activity->start_date, 'd/m/Y');
            $activity->end_date_formatted = Helpers::toFormatDateString($activity->end_date, 'd/m/Y');
            $activity->deadline_sign_ups_date_formatted = Helpers::toFormatDateString($activity->deadline_sign_ups_date, 'd/m/Y');
            #remove
            $activity->removed = false;

            if ($activity->post_type === 'organize') {
                $activity->image = "/assets/images/user_profiles/{$activity->image}";
                $activity->volunteering = VolunteeringActivity::where('user_id', $activity->user_id)->whereIn('status', ['live', 'closed'])->get()->count();
            }
        });
        return ['posts' => $data, 'total_count' => $total_count, 'count' => $count];
    }
}
