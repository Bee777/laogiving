<?php

namespace App\Models;

use App\Traits\UserRoleTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VolunteerSignUpActivity extends Model
{
    use UserRoleTrait;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public static function isConflictsSignUpActivity($sign_up_activity, $user_id, $status = ['confirm', 'checkin', 'pending'])
    {
        $activities = self::select('volunteer_sign_up_activities.*')
            ->join('volunteering_activities', 'volunteering_activities.id', 'volunteer_sign_up_activities.volunteering_activity_id')
            ->join('users', 'users.id', 'volunteer_sign_up_activities.user_id')
            ->join('user_types', 'user_types.user_id', 'users.id')
            ->where('user_types.type_user_id', (new self)->getTypeUserId('volunteer'))
            ->where('volunteer_sign_up_activities.user_id', $user_id)
            ->whereIn('volunteer_sign_up_activities.status', $status)
            ->where('volunteering_activities.status', 'live')
            ->where(DB::raw('abs(datediff(volunteering_activities.start_date, \'' . $sign_up_activity->start_date . '\'))'), '<', 5)
            ->where(DB::raw('abs(datediff(volunteering_activities.end_date, \'' . $sign_up_activity->end_date . '\'))'), '<', 5)
            ->where('volunteer_sign_up_activities.volunteering_activity_id', '!=', $sign_up_activity->id)
            ->get();
        return count($activities) > 0;
    }


    public static function getSignUpPositionUsers($activity_id, $position_id, $status = ['confirm', 'checkin'])
    {
        $users = self::select('volunteer_sign_up_activities.*', 'users.id as user_id', 'users.image as user_image')
            ->join('users', 'users.id', 'volunteer_sign_up_activities.user_id')
            ->join('user_types', 'user_types.user_id', 'users.id')
            ->where('user_types.type_user_id', (new self)->getTypeUserId('volunteer'))
            ->where('volunteer_sign_up_activities.volunteering_activity_id', $activity_id)
            ->where('volunteer_sign_up_activities.volunteering_activity_position_id', $position_id)
            ->whereIn('volunteer_sign_up_activities.status', $status)
            ->get();

        $users->map(function ($user) {
            $user->full_image_path = "/assets/images/user_profiles/{$user->user_image}";
        });
        return $users;
    }

    public static function getSignUpPositionPendingCount($activity_id, $position_id)
    {
        return self::where('volunteering_activity_id', $activity_id)
            ->where('volunteering_activity_position_id', $position_id)
            ->where('status', 'pending')
            ->get()->sum('slot');
    }

    public static function getSignUpPositionCount($activity_id, $position_id, $status = 'confirm')
    {
        return self::where('volunteering_activity_id', $activity_id)
            ->where('volunteering_activity_position_id', $position_id)
            ->whereIn('status', array_merge([$status], ['checkin']))
            ->get()->sum('slot');
    }

    public static function mapData($sign_up_activity, $need_gender)
    {
        if ($need_gender) {
            $volunteer = User::find($sign_up_activity->user_id);
            if (isset($volunteer)) {
                $profile = $volunteer->userProfile('volunteer');
                if (isset($profile)) {
                    $sign_up_activity->gender = $profile->gender;
                }
            }
        }
        $sign_up_activity->position = VolunteeringActivityPosition::where('volunteering_activity_id', $sign_up_activity->volunteering_activity_id)->where('id', $sign_up_activity->volunteering_activity_position_id)->first();

        return $sign_up_activity;
    }
}
