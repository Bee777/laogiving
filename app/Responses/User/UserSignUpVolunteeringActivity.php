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
use App\Models\CauseDetail;
use App\Models\Media;
use App\Models\Skill;
use App\Models\Suitable;
use App\Models\VolunteeringActivity;
use App\Models\VolunteeringActivityPosition;
use App\Models\VolunteeringActivityPositionSkill;
use App\Models\VolunteeringActivityPositionSuitable;
use App\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Validator;
use File;

class UserSignUpVolunteeringActivity implements Responsable
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
            $user = $request->user('api');
            if ($user->isUser('volunteer')) {
//                    dispatch(new SendNewVolunteeringCreated($volunteering));
                return response()->json(['success' => true, 'data' => $data]);
            }
            return response()->json(['success' => false, 'data' => $data]);
        }
    }
}
