<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 2/25/2019
 * Time: 11:03 PM
 */

namespace App\Responses\User;

use App\Http\Controllers\Helpers\Helpers;
use App\Jobs\SendNewVolunteeringCreated;
use App\Jobs\SendNewVolunteeringSignUp;
use App\Models\CauseDetail;
use App\Models\Media;
use App\Models\Skill;
use App\Models\Suitable;
use App\Models\VolunteeringActivity;
use App\Models\VolunteeringActivityPosition;
use App\Models\VolunteeringActivityPositionSkill;
use App\Models\VolunteeringActivityPositionSuitable;
use App\Models\VolunteerSignUpActivity;
use App\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Validator;
use File;

class UserSignUpVolunteeringActivity implements Responsable
{
    protected $activity;

    public function __construct($activity)
    {
        $this->activity = $activity;
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
            $user = $request->user('api');
            $signUpActivity = new VolunteerSignUpActivity();
            $signUpActivity->user_id = $user->id;
            $signUpActivity->slot = 1;
            $signUpActivity->volunteering_activity_position_id = $request->volunteer_position;
            $signUpActivity->sign_up_date = now();
            if ($this->activity->volunteer_contact_phone_number === 'yes') {
                $signUpActivity->volunteer_contact_phone_number = $request->volunteer_contact_phone_number;
            }
            if ($this->activity->other_response_required !== null && $this->activity->other_response_required !== '') {
                $signUpActivity->other_response_required = $request->other_response_answer;
            }
            $position_vacancies = VolunteeringActivityPosition::where('volunteering_activity_id', $this->activity->id)->where('id', $request->volunteer_position)->first();
            if ($position_vacancies->minimum_age && $position_vacancies->minimum_age > 12) {
                $signUpActivity->date_of_birth = Helpers::toFormatDateString($request->your_date_of_birth, 'Y-m-d H:i:s');
            }
            if ($this->activity->volunteer_signups_confirm === 'no') {
                $signUpActivity->status = 'confirm';
            }
            $signUpActivity->volunteering_activity_id = $this->activity->id;
            $signUpActivity->save();
            dispatch(new SendNewVolunteeringSignUp($signUpActivity, $user));
            $signUpActivity = VolunteerSignUpActivity::mapData($signUpActivity, $this->activity->volunteer_gender === 'yes');
            $data = ['sign_up' => $signUpActivity];
            return response()->json(['success' => true, 'data' => $data]);
        }
    }
}
