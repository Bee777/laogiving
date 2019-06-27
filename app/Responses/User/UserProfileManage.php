<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 2/26/2019
 * Time: 10:10 AM
 */

namespace App\Responses\User;


use App\Http\Controllers\Helpers\Helpers;
use App\Models\CauseDetail;
use App\Models\Media;
use App\Models\OrganizeProfile;
use App\Models\VolunteerProfile;
use Illuminate\Contracts\Support\Responsable;
use App\User;
use Image, File;

class UserProfileManage implements Responsable
{
    protected $req;
    protected $uploadPath = '/assets/images/posts/';

    public function __construct($request = null)
    {
        $this->req = $request;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        $data = $request->all();
        if (Helpers::isAjax($request)) {
            $type = $request->get('type');

            if ($this->hasType($type)) {
                $user = $request->user();
                //check if admin return back
                if (User::isAdminUser($user)) {
                    return response()->json(['success' => true, 'data' => $data]);
                }
                //check if admin return back

                //Personal Information
                $user->name = $request->get('display_name');
                $this->saveImageProfile($user);
                $user->save();
                //Personal Information

                #Cause Details
                $causes = $request->get('user_causes', []);
                if (is_array($causes) && count($causes) > 0) {
                    CauseDetail::saveUser($user, $causes);
                } else {
                    CauseDetail::saveUser($user, []);
                }
                #Cause Details
                if ($type === 'volunteer' && $user->isUser('volunteer')) {

                    $hasProfile = true;
                    $userProfile = $user->userProfile($type);
                    if (!isset($userProfile)) {
                        $userProfile = new VolunteerProfile();
                        $hasProfile = false;
                    }
                    //Salutation, Gender Information
                    if ($this->salutation($request->get('salutation'))) {
                        $userProfile->salutation = $request->get('salutation');
                    }
                    if ($this->gender($request->get('gender'))) {
                        $userProfile->gender = $request->get('gender');
                    }
                    //Salutation, Gender Information
                    $userProfile->display_name = $request->get('display_name');

                    if ($request->has('public_email')) {
                        $userProfile->public_email = $request->get('public_email');
                    }

                    //Personal Information
                    if ($request->has('date_of_birth') && !empty($request->get('date_of_birth'))) {
                        $userProfile->date_of_birth = Helpers::toFormatDateString($request->get('date_of_birth'), 'Y-m-d H:i:s');
                    }
                    if ($request->has('phone_number')) {
                        if ($request->get('phone_number') !== null && !Helpers::isValidPhoneNumber($request->get('phone_number'))) {
                            return response()->json(['errors' => ['phone_number' => ['Your phone number is invalid.']]], 422);
                        }
                        $userProfile->phone_number = $request->get('phone_number');
                    }

                    //@Save User Profile
                    if (!$hasProfile) {
                        $user->saveUserProfile($type, $userProfile);
                    } else {
                        $userProfile->save();
                    }
                    //@Save User Profile
                } else if ($type === 'organize' && $user->isUser('organize')) { //@End Volunteer

                    //media video and images
                    #youtube
                    $userMediaVideoModel = Media::single('user', 'youtube', $user->id);
                    $user_media_video_url = $request->get('user_media_video_url');

                    if (isset($userMediaVideoModel)) {
                        Media::updateUser($userMediaVideoModel->id, $user->id, 'youtube', (string)$user_media_video_url);
                    } else {
                        Media::saveUser($user->id, 'youtube', (string)$user_media_video_url);
                    }
                    //#images
                    $userMediaImagesModel = Media::list('user', 'image', $user->id);
                    $user_media_images = $request->file('user_media_images');
                    $user_media_images_cleared = $request->get('user_media_images_cleared');

                    #delete cleared images
                    if (is_array($user_media_images_cleared) && count($user_media_images_cleared) > 0) {
                        Media::deleteMultiData($user_media_images_cleared);
                    }
                    #manage slide images data
                    if (is_array($user_media_images) && count($user_media_images) > 0) {
                        Media::saveMultiData($user->id, 'user', 'image', $user_media_images);
                    } else {
                        foreach ($userMediaImagesModel as $imageModel) {
                            Helpers::removeFile(Media::$uploadPath . $imageModel->url);
                            $imageModel->delete();
                        }
                    }

                    $hasProfile = true;
                    $userProfile = $user->userProfile($type);
                    if (!isset($userProfile)) {
                        $userProfile = new OrganizeProfile();
                        $hasProfile = false;
                    }

                    //Group size, Visibility Information
                    if ($this->group_size($request->get('group_size'))) {
                        $userProfile->group_size = $request->get('group_size');
                    }

                    if ($this->visibility($request->get('visibility'))) {
                        $userProfile->visibility = $request->get('visibility');
                    }
                    //Group size, Visibility Information

                    //General Information
                    $userProfile->display_name = $request->get('display_name');

                    if ($request->has('about')) {
                        $userProfile->about = $request->get('about');
                    }
                    if ($request->has('vision_mission')) {
                        $userProfile->vision_mission = $request->get('vision_mission');
                    }
                    if ($request->has('website')) {
                        $userProfile->website = $request->get('website');
                    }

                    if ($request->has('our_programmes')) {
                        $userProfile->our_programmes = $request->get('our_programmes');
                    }
                    if ($request->has('facebook')) {
                        $userProfile->facebook = $request->get('facebook');
                    }

                    if ($request->has('public_email')) {
                        $userProfile->public_email = $request->get('public_email');
                    }
                    if ($request->has('contact_person')) {
                        $userProfile->contact_person = $request->get('contact_person');
                    }
                    if ($request->has('address')) {
                        $userProfile->address = $request->get('address');
                    }
                    if ($request->has('registration_date') && !empty($request->get('registration_date'))) {
                        $userProfile->registration_date = Helpers::toFormatDateString($request->get('registration_date'), 'Y-m-d H:i:s');
                    }
                    if ($request->has('phone_number')) {
                        if ($request->get('phone_number') !== null && !Helpers::isValidPhoneNumber($request->get('phone_number'))) {
                            return response()->json(['errors' => ['phone_number' => ['Your phone number is invalid.']]], 422);
                        }
                        $userProfile->phone_number = $request->get('phone_number');
                    }
                    //General Information
                    //@Save User Profile
                    if (!$hasProfile) {
                        $user->saveUserProfile($type, $userProfile);
                    } else {
                        $userProfile->save();
                    }
                    //@Save User Profile
                }
            }
            return response()->json(['success' => true, 'data' => $data]);
        }
    }

    public function saveImageProfile($user): void
    {
        if ($this->req->hasFile('profile_image')) {
            $file = $this->req->file('profile_image');
            $fileExt = strtolower($file->getClientOriginalExtension());
            $imgOriginalName = Helpers::subFileName($file->getClientOriginalName()) . md5('^');
            $img_filename = $imgOriginalName . md5(uniqid('profile-volunteer', true)) . '_profile.' . $fileExt;
            $uploadPath = $user->userInfo['imagePath'];
            $preThumb = $user->userInfo['preThumb'];
            if ($fileExt === 'gif' || $fileExt === 'svg') {
                $location = public_path($uploadPath);
                $file->move($location, $img_filename);
                File::copy($location . $img_filename, $location . $preThumb . $img_filename);
            } else {
                //save original
                $img = Image::make($file);
                $location = public_path($uploadPath . $img_filename);
                $img->save($location)->destroy();
                //save original
                //save thumb
                $img = Image::make($file);
                // add callback functionality to retain maximal original image size
                $img->fit(96, 96, function ($constraint) {
                    $constraint->upsize();
                });
                $location = public_path($uploadPath . $preThumb . $img_filename);
                $img->save($location)->destroy();
                //save thumb
            }
            if ($user->image !== 'logo.png') {
                Helpers::removeFile($uploadPath . $preThumb . $user->image);
                Helpers::removeFile($uploadPath . $user->image);
            }
            $user->image = $img_filename;
            $user->save();
        }
    }

    public function hasType($title)
    {
        $types = ['volunteer', 'organize'];
        return in_array($title, $types, true);
    }

    public function gender($title)
    {
        $gender = ['none', 'male', 'female'];
        return in_array(strtolower($title), $gender, true);
    }

    public function salutation($title)
    {
        $salutation = ['none', 'mr', 'ms', 'mrs', 'miss', 'mdm', 'dr'];
        return in_array(strtolower($title), $salutation, true);
    }

    public function group_size(string $title)
    {
        $sizes = ['0', '10', '50', '200', '201'];
        return in_array($title, $sizes, true);
    }

    public function visibility(string $title)
    {
        $visibilities = ['none', 'visible', 'hidden'];
        return in_array($title, $visibilities, true);
    }
}
