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
use App\User;
use Illuminate\Contracts\Support\Responsable;

class UserProfileOptions implements Responsable
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
            $type = $request->get('type');
            if ($this->hasType($type)) {
                $user = $request->user();
                if ($user->isUser('volunteer') || $user->isUser('organize')) {
                    $data = $this->transformUserProfile($request->user(), $type);
                }
                $data['causes'] = Cause::getCauses('all');
                return response()->json(['success' => true, 'data' => $data]);
            }
            return response()->json(['success' => false, 'data' => $data]);
        }
    }

    public function hasType($title)
    {
        $types = ['volunteer', 'organize'];
        return in_array($title, $types, true);
    }

    public function transformUserProfile(User $user, $type)
    {
        $data = null;
        if (isset($user)) {
            $data = [];
            $data['name'] = $user->name;
            $data['email'] = $user->email;
            if ($type === 'volunteer') {
                $userProfile = $user->userProfile($type);
                $data['user_profile'] = $userProfile;
                if (isset($userProfile)) {
                    $data['user_profile']['date_of_birth_formatted'] = $userProfile->date_of_birth->format('d/m/Y');
                    $data['user_profile']['profile_image_base64'] = '';
                }
                $data['user_causes'] = CauseDetail::list('user', $user->id)->pluck('cause_id');
            } else if ($type === 'organize') {
                $userProfile = $user->userProfile($type);
                $data['user_profile'] = $userProfile;
                if (isset($userProfile)) {
                    $data['user_profile']['visibility'] = $userProfile->visibility === 'visible';
                    $data['user_profile']['registration_date_formatted'] = $userProfile->registration_date->format('d/m/Y');
                    $data['user_profile']['profile_image_base64'] = '';
                    $data['user_profile']['website_in_our_site'] = $userProfile->visibility ? route('get.home.organize.profile', $user->id) : '';

                }
                $data['user_causes'] = CauseDetail::list('user', $user->id)->pluck('cause_id');
            }
        }
        return $data;
    }
}
