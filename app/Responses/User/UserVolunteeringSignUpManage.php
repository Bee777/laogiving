<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 2/25/2019
 * Time: 11:03 PM
 */

namespace App\Responses\User;

use App\Http\Controllers\Helpers\Helpers;
use App\Models\VolunteeringActivity;
use App\Models\VolunteerSignUpActivity;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;

class UserVolunteeringSignUpManage implements Responsable
{
    protected $actionType = 'get';
    protected $options = [];

    public function __construct($actionType, $options = [])
    {
        $this->options = $options;
        $this->actionType = $actionType;
    }

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
                if ($this->actionType === 'change-status' && isset($this->options['single'])) {
                    if (!$this->options['single']) {
                        $data = $request->data;
                        if (is_array($data) && count($data) > 0) {
                            foreach ($data as $sign_up_data) {
                                $signUpVolunteering = VolunteerSignUpActivity::select('volunteer_sign_up_activities.*')
                                    ->join('volunteering_activities', 'volunteering_activities.id', 'volunteer_sign_up_activities.volunteering_activity_id')
                                    ->where('volunteering_activities.user_id', $user->id)->where('volunteer_sign_up_activities.id', $sign_up_data['id'] ?? 0)->first();

                                if (isset($signUpVolunteering) && $sign_up_data['status'] !== 'withdrawn' && $this->statuses($sign_up_data['status'])) {
                                    $this->changeStaus($signUpVolunteering, $sign_up_data['status']);
                                }
                            }
                            return response()->json(['success' => true, 'data' => $data]);
                        }
                    } else if ($this->options['single'] === true) {
                        $signUpVolunteering = VolunteerSignUpActivity::select('volunteer_sign_up_activities.*')
                            ->join('volunteering_activities', 'volunteering_activities.id', 'volunteer_sign_up_activities.volunteering_activity_id')
                            ->where('volunteering_activities.user_id', $user->id)->where('volunteer_sign_up_activities.id', $request->id)->first();
                        if (isset($signUpVolunteering) && $request->status !== 'withdrawn' && $this->statuses($request->status)) {
                            $this->changeStaus($signUpVolunteering, $request->status);
                            return response()->json(['success' => true, 'data' => VolunteerSignUpActivity::find($request->id)]);
                        }
                    }
                } else if ($this->actionType === 'change-attendance') {
                    $data = $request->data;
                    if (is_array($data) && count($data) > 0) {
                        foreach ($data as $key => $sign_up_data) {

                            $signUpVolunteering = VolunteerSignUpActivity::select('volunteer_sign_up_activities.*')
                                ->join('volunteering_activities', 'volunteering_activities.id', 'volunteer_sign_up_activities.volunteering_activity_id')
                                ->where('volunteering_activities.user_id', $user->id)
                                ->whereIn('volunteer_sign_up_activities.status', ['confirm', 'checkin'])
                                ->where('volunteer_sign_up_activities.id', $sign_up_data['id'] ?? 0)->first();

                            if (isset($signUpVolunteering)) {
                                if (isset($sign_up_data['hour_per_volunteer'])) {
                                    $hours = $sign_up_data['hour_per_volunteer'];
                                    if ($hours >= 0 && $hours < 1000000) {
                                        $signUpVolunteering->hour_per_volunteer = $sign_up_data['hour_per_volunteer'];
                                    }
                                }
                                if (isset($sign_up_data['checked']) && $sign_up_data['checked'] === true) {
                                    $signUpVolunteering->checkin_date = now();
                                    $signUpVolunteering->status = 'checkin';
                                    $data[$key]['checkin_date'] = $signUpVolunteering->checkin_date;
                                    $data[$key]['status'] = $signUpVolunteering->status;
                                } else {
                                    $signUpVolunteering->checkin_date = null;
                                    $signUpVolunteering->status = 'confirm';
                                    $data[$key]['checkin_date'] = $signUpVolunteering->checkin_date;
                                    $data[$key]['status'] = $signUpVolunteering->status;
                                }
                                $signUpVolunteering->save();
                            }
                        }
                        return response()->json(['success' => true, 'data' => $data]);
                    }
                } else if ($this->actionType === 'fetch-all-volunteers') {

                    $paginateLimit = ($request->exists('limit') && !empty($request->get('limit'))) ? $request->get('limit') : 10;
                    $paginateLimit = Helpers::isNumber($paginateLimit) ? $paginateLimit : 10;
                    $text = $request->get('q');

                    $data = VolunteerSignUpActivity::select('volunteer_sign_up_activities.*', 'users.name as user_name', 'users.image', 'volunteer_profiles.salutation', 'volunteer_profiles.public_email', 'volunteer_profiles.phone_number',
                        DB::raw('count(volunteer_sign_up_activities.user_id) as  activities_count'))
                        ->join('volunteering_activities', 'volunteering_activities.id', 'volunteer_sign_up_activities.volunteering_activity_id')
                        ->join('users', 'users.id', 'volunteer_sign_up_activities.user_id')
                        ->leftJoin('volunteer_profiles', 'volunteer_profiles.user_id', 'users.id')
                        ->where('volunteering_activities.user_id', $user->id)
                        ->groupBy('users.id')
                        ->orderBy('users.name', 'asc');
                    if ($request->role === 'leader') {
                        $data = $data->where('volunteer_sign_up_activities.leader', 'yes')->paginate($paginateLimit);
                    } else {
                        $data = $data->paginate($paginateLimit);
                    }
                    $data->appends(['limit' => $paginateLimit, 'q' => $text]);
                    #counting
                    $all_volunteers = VolunteerSignUpActivity::select('volunteer_sign_up_activities.*')
                        ->join('volunteering_activities', 'volunteering_activities.id', 'volunteer_sign_up_activities.volunteering_activity_id')
                        ->join('users', 'users.id', 'volunteer_sign_up_activities.user_id')
                        ->leftJoin('volunteer_profiles', 'volunteer_profiles.user_id', 'users.id')
                        ->where('volunteering_activities.user_id', $user->id)
                        ->groupBy('users.id')
                        ->orderBy('users.name', 'asc')->get();

                    $total_leaders = VolunteerSignUpActivity::select(DB::raw("COUNT( DISTINCT (volunteer_sign_up_activities.user_id))  AS `leaders_count`"))
                        ->join('volunteering_activities', 'volunteering_activities.id', 'volunteer_sign_up_activities.volunteering_activity_id')
                        ->join('users', 'users.id', 'volunteer_sign_up_activities.user_id')
                        ->where('volunteer_sign_up_activities.leader', 'yes')
                        ->where('volunteering_activities.user_id', $user->id)
                        ->groupBy('volunteer_sign_up_activities.user_id')
                        ->get()->sum('leaders_count');

                    $statuses = [
                        'total_volunteers' => count($all_volunteers),
                        'total_leaders' => $total_leaders,
                    ];
                    #counting
                    return response()->json(['success' => true, 'statuses' => $statuses, 'data' => $data]);
                }
            } else if ($user->isUser('volunteer')) {
                $status = $request->get('selectedStatus');
                $signUpId = $request->get('sign_up_id');
                #user withdrawn
                if ($this->actionType === 'change-status' && isset($this->options['single']) && $this->options['single'] === true) {
                    $signUpVolunteering = VolunteerSignUpActivity::select('volunteer_sign_up_activities.*')
                        ->join('volunteering_activities', 'volunteering_activities.id', 'volunteer_sign_up_activities.volunteering_activity_id')
                        ->where('volunteer_sign_up_activities.user_id', $user->id)
                        ->where('volunteer_sign_up_activities.id', $signUpId)->first();
                    if (isset($signUpVolunteering) && $status === 'withdrawn') {
                        $this->changeStaus($signUpVolunteering, $status);
                        return response()->json(['success' => true, 'data' => VolunteerSignUpActivity::find($signUpId)]);
                    }
                }
                #user withdrawn
                #leader
                $activity = VolunteeringActivity::where('status', 'live')->where('id', $request->volunteering_activity_id)->first();
                $signUpVolunteeringLeader = VolunteerSignUpActivity::select('volunteer_sign_up_activities.*')
                    ->join('volunteering_activities', 'volunteering_activities.id', 'volunteer_sign_up_activities.volunteering_activity_id')
                    ->where('volunteer_sign_up_activities.user_id', $user->id)
                    ->where('volunteer_sign_up_activities.leader', 'yes')
                    ->where('volunteer_sign_up_activities.volunteering_activity_id', $activity->id ?? 0)->first();
                if (isset($signUpVolunteeringLeader)) {
                    if ($this->actionType === 'change-status' && isset($this->options['single'])) {
                        if (!$this->options['single']) {
                            $data = $request->data;
                            if (is_array($data) && count($data) > 0) {
                                foreach ($data as $sign_up_data) {
                                    $signUpVolunteering = VolunteerSignUpActivity::select('volunteer_sign_up_activities.*')
                                        ->join('volunteering_activities', 'volunteering_activities.id', 'volunteer_sign_up_activities.volunteering_activity_id')
                                        ->where('volunteering_activities.id', $activity->id)
                                        ->where('volunteering_activities.user_id', $activity->user_id)
                                        ->where('volunteer_sign_up_activities.id', $sign_up_data['id'] ?? 0)->first();

                                    if (isset($signUpVolunteering) && $sign_up_data['status'] !== 'withdrawn' && $this->statuses($sign_up_data['status'])) {
                                        $this->changeStaus($signUpVolunteering, $sign_up_data['status']);
                                    }
                                }
                                return response()->json(['success' => true, 'data' => $data]);
                            }
                        } else if ($this->options['single'] === true) {
                            $signUpVolunteering = VolunteerSignUpActivity::select('volunteer_sign_up_activities.*')
                                ->join('volunteering_activities', 'volunteering_activities.id', 'volunteer_sign_up_activities.volunteering_activity_id')
                                ->where('volunteering_activities.id', $activity->id)
                                ->where('volunteering_activities.user_id', $activity->user_id)->where('volunteer_sign_up_activities.id', $request->id)->first();
                            if (isset($signUpVolunteering) && $request->status !== 'withdrawn' && $this->statuses($request->status)) {
                                $this->changeStaus($signUpVolunteering, $request->status);
                                return response()->json(['success' => true, 'data' => VolunteerSignUpActivity::find($request->id)]);
                            }
                        }
                    } else if ($this->actionType === 'change-attendance') {
                        $data = $request->data;
                        if (is_array($data) && count($data) > 0) {
                            foreach ($data as $key => $sign_up_data) {

                                $signUpVolunteering = VolunteerSignUpActivity::select('volunteer_sign_up_activities.*')
                                    ->join('volunteering_activities', 'volunteering_activities.id', 'volunteer_sign_up_activities.volunteering_activity_id')
                                    ->where('volunteering_activities.id', $activity->id)
                                    ->where('volunteering_activities.user_id', $activity->user_id)
                                    ->whereIn('volunteer_sign_up_activities.status', ['confirm', 'checkin'])
                                    ->where('volunteer_sign_up_activities.id', $sign_up_data['id'] ?? 0)->first();

                                if (isset($signUpVolunteering)) {
                                    if (isset($sign_up_data['hour_per_volunteer'])) {
                                        $hours = $sign_up_data['hour_per_volunteer'];
                                        if ($hours >= 0 && $hours < 1000000) {
                                            $signUpVolunteering->hour_per_volunteer = $sign_up_data['hour_per_volunteer'];
                                        }
                                    }
                                    if (isset($sign_up_data['checked']) && $sign_up_data['checked'] === true) {
                                        $signUpVolunteering->checkin_date = now();
                                        $signUpVolunteering->status = 'checkin';
                                        $data[$key]['checkin_date'] = $signUpVolunteering->checkin_date;
                                        $data[$key]['status'] = $signUpVolunteering->status;
                                    } else {
                                        $signUpVolunteering->checkin_date = null;
                                        $signUpVolunteering->status = 'confirm';
                                        $data[$key]['checkin_date'] = $signUpVolunteering->checkin_date;
                                        $data[$key]['status'] = $signUpVolunteering->status;
                                    }
                                    $signUpVolunteering->save();
                                }
                            }
                            return response()->json(['success' => true, 'data' => $data]);
                        }
                    }
                }
            }
            return response()->json(['success' => false, 'data' => $data]);
        }
    }

    public function statuses($title)
    {
        $statuses = ['confirm', 'rejected', 'confirm_and_make_leader', 'withdrawn'];
        return in_array($title, $statuses, true);
    }

    public function changeStaus($signUpVolunteering, $status = 'confirm')
    {
        if ($status === 'confirm_and_make_leader') {
            $signUpVolunteering->status = 'confirm';
            $signUpVolunteering->leader = 'yes';
        } else if ($signUpVolunteering->status !== 'pending') {
            $signUpVolunteering->status = $status !== 'pending' ? $status : $signUpVolunteering->status;
            $signUpVolunteering->leader = 'no';
            #reset checkin_date
            if ($status !== 'confirm' && $status !== 'confirm_and_make_leader') {
                $signUpVolunteering->checkin_date = null;
                $signUpVolunteering->hour_per_volunteer = 0;
            }
        } else {
            $signUpVolunteering->status = $status;
        }
        $signUpVolunteering->save();
    }
}
