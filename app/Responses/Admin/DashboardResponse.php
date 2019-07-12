<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 3/2/2019
 * Time: 2:46 PM
 */

namespace App\Responses\Admin;

use App\Http\Controllers\Helpers\Helpers;
use App\Models\Posts;
use App\Models\VolunteeringActivity;
use App\Traits\UserRoleTrait;
use App\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;

class DashboardResponse implements Responsable
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
            $data = [];
            $data['latest_members_count'] = User::join('user_types', 'user_types.user_id', 'users.id')->whereIn('user_types.type_user_id', User::getNonAdminUserIds())->count();
            $data['news_count'] = $this->getPostsCount('news')['all'];
            $user = $request->user('api');
            if ($user->isUser('admin') || $user->isUser('super_admin')) {
                $data['activities_count'] = $this->getVolunteeringCount();
                $data['volunteering_hours'] = $this->getVolunteeringHours();
                $data['latest_volunteers_count'] = User::join('user_types', 'user_types.user_id', 'users.id')->where('user_types.type_user_id', $this->getTypeUserId('volunteer'))->count();
                $data['latest_organizes_count'] = User::join('user_types', 'user_types.user_id', 'users.id')->where('user_types.type_user_id', $this->getTypeUserId('organize'))->count();
            }
            return response()->json(['data' => $data]);
        }
    }

    public function getPostsCount($type): array
    {
        $data = [];
        $data['active'] = Posts::where('type', $type)->where('status', 'open')->count();
        $data['all'] = Posts::where('type', $type)->count();
        return $data;
    }

    private function getVolunteeringCount()
    {
        $volunteering_activities = DB::table('volunteering_activities')
            ->join('users', 'users.id', 'volunteering_activities.user_id')
            ->join('user_types', 'user_types.user_id', 'users.id')
            ->selectRaw("SUM(CASE WHEN volunteering_activities.status = 'live' THEN 1 ELSE 0 END) AS `LIVE_COUNT`,
                SUM(CASE WHEN volunteering_activities.status = 'closed' THEN 1 ELSE 0 END) AS `CLOSED_COUNT`,
                SUM(CASE WHEN volunteering_activities.status = 'draft' THEN 1 ELSE 0 END) AS `DRAFT_COUNT`,
                SUM(CASE WHEN volunteering_activities.status = 'cancelled' THEN 1 ELSE 0 END) AS `CANCELLED_COUNT`")
            ->where('user_types.type_user_id', $this->getTypeUserId('organize'))
            ->where('users.status', 'approved')
            ->first();

        $success_volunteering_activities = DB::table('volunteering_activities')
            ->selectRaw('COUNT(DISTINCT volunteering_activities.id) AS `SUCCESS_COUNT`')
            ->join('volunteer_sign_up_activities', 'volunteer_sign_up_activities.volunteering_activity_id', '=', 'volunteering_activities.id')
            ->where('volunteering_activities.status', 'closed')
            ->whereIn('volunteer_sign_up_activities.status', ['confirm', 'checkin'])
            ->first();

        $data = [];
        $data['active'] = $volunteering_activities->LIVE_COUNT;
        $data['all'] = DB::table('volunteering_activities')->get()->count();
        $data['success'] = $success_volunteering_activities->SUCCESS_COUNT;
        return $data;
    }

    public function getVolunteeringHours()
    {
        return DB::table('volunteer_sign_up_activities')->get()->sum('hour_per_volunteer');
    }
}
