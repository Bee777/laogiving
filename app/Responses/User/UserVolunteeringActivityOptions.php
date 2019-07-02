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
            $type = $request->get('type');

            $user = $request->user();
            if ($user->isUser('organize')) {
                $data = [];
            }
            $data['causes'] = Cause::getCauses('all');
            $data['skills'] = Skill::getSkills('all');
            $data['suitables'] = Suitable::getSuitables('all');
            return response()->json(['success' => true, 'data' => $data]);

            return response()->json(['success' => false, 'data' => $data]);
        }
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
                    $data['user_profile']['date_of_birth_formatted'] = isset($userProfile->date_of_birth) ? $userProfile->date_of_birth->format('d/m/Y') : '';
                    $data['user_profile']['profile_image_base64'] = '';
                }
                $data['user_causes'] = CauseDetail::list('user', $user->id)->pluck('cause_id');
                $user_causes = CauseDetail::list('user', $user->id);
                $user_causes->map(function ($item) {
                    $item->cause_data = $item->cause;
                    return $item;
                });
                $data['user_causes_display'] = $user_causes->pluck('cause_data');
            } else if ($type === 'organize') {
                $userProfile = $user->userProfile($type);
                $data['user_profile'] = $userProfile;
                if (isset($userProfile)) {
                    $data['user_profile']['visibility'] = $userProfile->visibility === 'visible';
                    $data['user_profile']['registration_date_formatted'] = isset($userProfile->registration_date) ? $userProfile->registration_date->format('d/m/Y') : '';
                    $data['user_profile']['profile_image_base64'] = '';
                    $data['user_profile']['website_in_our_site'] = $userProfile->visibility ? route('get.home.organize.profile', $user->id) : '';

                }
                $data['user_causes'] = CauseDetail::list('user', $user->id)->pluck('cause_id');
                $user_causes = CauseDetail::list('user', $user->id);
                $user_causes->map(function ($item) {
                    $item->cause_data = $item->cause;
                    return $item;
                });
                $data['user_causes_display'] = $user_causes->pluck('cause_data');
                $data['user_media'] = [
                    'video' => ['validated' => '', 'url' => ''],
                    'images' => [
                        [
                            'image_base64' => '',
                            'image' => null,
                            'validated' => '',
                            'removable' => false
                        ]
                    ]
                ];
                $userMediaVideo = Media::single('user', 'youtube', $user->id);
                if (isset($userMediaVideo)) {
                    $data['user_media']['video'] = $userMediaVideo;
                }
                $userMediaImages = Media::list('user', 'image', $user->id);
                if (count($userMediaImages) > 0) {
                    $data['user_media']['images'] = $userMediaImages;
                }
            }
        }
        return $data;
    }
}
