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
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Validator;
use File;

class UserVolunteeringActivityManage implements Responsable
{
    protected $actionType = 'get';
    protected $options = [];

    public function __construct($actionType, $options = [])
    {
        $this->options = $options;
        $this->actionType = $actionType;
    }
//    GET
    public function get($request)
    {
        $fields = [
            'name',
            'description',
            'volunteer_type',
            'duration',
            'start_date',
            'end_date',
            'deadline_sign_ups_date',
            'points_to_note',
            'other_response_required',
            'town',
            'block_street',
            'building_name',
            'building_unit_number',
            'contact_title',
            'contact_name',
            'contact_designation',
            'contact_phone_number',
            'contact_email',
            'created_at', 'updated_at'];
        $request->request->add(['fields' => $fields]);
        $text = $this->options['text'];
        $paginateLimit = $this->options['limit'];
        $status = strtolower($request->volunteering);
        $data = VolunteeringActivity::select(array_merge($fields, [
            'id',
            'frequency',
            'weekday',
            'weekend',
            'volunteer_gender',
            'volunteer_contact_phone_number',
            'volunteer_signups_confirm',
            'status',
        ]))->where('user_id', auth()->user()->id)->where('status', $status);
        $data->where(function ($query) use ($request, $text) {
            foreach ($request->fields as $k => $f) {
                if ($f === 'start_date' || $f === 'end_date' ||
                    $f === 'deadline_sign_ups_date' || $f === 'created_at' || $f === 'updated_at') {
                    if (Helpers::isEngText($text)) {
                        $query->orWhere($f, 'LIKE', "%{$text}%");
                    } else {
                        continue;
                    }
                }
                $query->orWhere($f, 'LIKE', "%{$text}%");
            }
        });

        $data = $data->orderBy('name', 'asc')->paginate($paginateLimit);
//      $data = $data->orderBy('created_at', 'asc')->paginate($paginateLimit);
//      $data = $data->orderBy('created_at', 'desc')->paginate($paginateLimit);

        $data->map(function ($activity) {
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
            #date map
            $activity->start_date_formatted = Helpers::toFormatDateString($activity->start_date, 'd/m/Y');
            $activity->end_date_formatted = Helpers::toFormatDateString($activity->end_date, 'd/m/Y');
            $activity->deadline_sign_ups_date_formatted = Helpers::toFormatDateString($activity->deadline_sign_ups_date, 'd/m/Y');

            #activity register status
            $activity->active_opportunity = 0;
            $activity->signup_pending_confirmation = 0;
        });

        return $data;
    }
// END   GET
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
                #declare var
                $step = (int)$request->step;
                $isDraft = $request->draft === 'true';
                #end declare var
                #START CREATE
                if ($this->actionType === 'create') {
                    #step 1
                    $volunteering = new VolunteeringActivity();
                    $volunteering->name = $request->title;
                    $volunteering->description = $request->description;
                    #step 2
                    $volunteering->frequency = $request->get('frequency', '');
                    $volunteering->duration = $request->get('duration', 0);
                    $volunteering->volunteer_type = $request->get('volunteering_type', 'regular');

                    $days_of_weeks = $request->get('days_of_week', []);
                    $volunteering->weekday = in_array('WEEKDAY', $days_of_weeks, true) ? 'yes' : 'no';
                    $volunteering->weekend = in_array('WEEKEND', $days_of_weeks, true) ? 'yes' : 'no';

                    $volunteering->start_date = Helpers::toFormatDateString($request->get('commitment_from_date'), 'Y-m-d H:i:s');
                    $volunteering->end_date = Helpers::toFormatDateString($request->get('commitment_to_date'), 'Y-m-d H:i:s');
                    $volunteering->deadline_sign_ups_date = Helpers::toFormatDateString($request->get('deadline_for_sign_ups_date'), 'Y-m-d H:i:s');

                    $volunteering->town = $request->get('town', '');
                    $volunteering->block_street = $request->get('block_street', '');
                    $volunteering->building_name = $request->building_name;
                    $volunteering->building_unit_number = $request->unit;
                    #step 3
                    $volunteering->points_to_note = $request->points_to_note;
                    $volunteering->volunteer_gender = $request->volunteer_gender === 'true' ? 'yes' : 'no';
                    $volunteering->volunteer_contact_phone_number = $request->volunteer_contact_phone_number === 'true' ? 'yes' : 'no';
                    $volunteering->other_response_required = $request->other_response_required;
                    $volunteering->volunteer_signups_confirm = $request->volunteer_signups_confirm === 'true' ? 'yes' : 'no';
                    #step 4
                    $volunteering->contact_title = $request->get('contact_title', '');
                    $volunteering->contact_name = $request->get('contact_name', '');
                    $volunteering->contact_designation = $request->get('contact_designation', '');
                    $volunteering->contact_phone_number = $request->get('contact_phone_number', '');
                    $volunteering->contact_email = $request->get('contact_email', '');
                    $volunteering->user_id = $user->id;
                    $volunteering->status = $isDraft ? 'draft' : 'live';
                    $volunteering->save();//@save volunteering
                    #step 1 re save
                    #1-media
                    #1-Cause Details
                    $causes = $request->causes;
                    CauseDetail::saveActivity($volunteering, $causes);
                    #1-media video and images
                    #1-youtube
                    $activity_media_video_url = $request->get('media_video_url');
                    Media::saveActivity($volunteering->id, 'youtube', (string)$activity_media_video_url);
                    #1-images
                    $media_images = $request->file('media_images');
                    #duplicate images and video
                    $duplicate_id = $request->get('duplicate');
                    $duplicateModel = VolunteeringActivity::find($duplicate_id);
                    $isDuplicate = isset($duplicateModel);
                    if ($isDuplicate) {
                        $activityMediaImages = Media::list('activity', 'image', $duplicateModel->id);
                        #set step 1
                        foreach ($activityMediaImages as $item) {
                            $url = $duplicateModel->id . '-dp-' . $item->url;
                            $filenameLength = mb_strlen($url, 'UTF-8');
                            $location = public_path('/assets/images/media/images/');
                            if ($filenameLength > 180) {
                                $path_info = pathinfo($location . $item->url);
                                $url = mb_substr($url, 0, 180, 'UTF-8') . '.' . $path_info['extension'];
                            }
                            File::copy($location . $item->url, $location . $url);
                            $mediaModel = new Media();
                            $mediaModel->url = $url;
                            $mediaModel->media_type = 'image';
                            $mediaModel->related_type = 'activity';
                            $mediaModel->related_id = $volunteering->id;
                            $mediaModel->save();
                        }
                        #set step 1
                    } else {
                        Media::saveMultiData($volunteering->id, 'activity', 'image', $media_images);
                    }
                    #step 3 re save
                    $positions = $request->positions;
                    if (is_array($positions)) {
                        foreach ($positions as $position) {
                            $position = json_decode($position);
                            $positionModel = new VolunteeringActivityPosition();
                            $positionModel->title = $position->position_title;
                            $positionModel->vacancies = $position->vacancies;
                            $positionModel->minimum_age = empty($position->minimum_age) ? null : $position->minimum_age;
                            $positionModel->key_responsibilities_impact = $position->key_responsibilities;
                            $positionModel->volunteering_activity_id = $volunteering->id;
                            $positionModel->save();
                            $skills = $position->position_skills;
                            foreach ($skills as $skill) {
                                $existSkill = Skill::find($skill);
                                if (isset($existSkill)) {
                                    $skillModel = new VolunteeringActivityPositionSkill();
                                    $skillModel->skill_id = $skill;
                                    $positionModel->skills()->save($skillModel);
                                }
                            }
                            $suitables = $position->position_suitables;
                            foreach ($suitables as $suitable) {
                                $existSuitable = Suitable::find($suitable);
                                if (isset($existSuitable)) {
                                    $suitableModel = new VolunteeringActivityPositionSuitable();
                                    $suitableModel->suitable_id = $suitable;
                                    $positionModel->suitables()->save($suitableModel);
                                }
                            }
                        }
                    }
                    $data = $volunteering;
                    if ($volunteering->status === 'live') {
                        dispatch(new SendNewVolunteeringCreated($volunteering));
                    }
                    return response()->json(['success' => true, 'data' => $data]);
                }
                #END CREATE

                #START UPDATE
                if ($this->actionType === 'update') {
                    $volunteering = VolunteeringActivity::where('user_id', $user->id)->where('id', $request->id)->first();

                    if (isset($volunteering)) {
                        #step 1
                        if (($step === 1 || $step === 5) || ($isDraft && $step >= 1)) {
                            $volunteering->name = $request->title;
                            $volunteering->description = $request->description;
                            #step 1 re save
                            #1-media
                            #1-Cause Details
                            $causes = $request->causes;
                            CauseDetail::saveActivity($volunteering, $causes);
                            #1-media video and images
                            #1-youtube
                            $activity_media_video_url = $request->get('media_video_url');
                            $activityMediaVideoModel = Media::single('activity', 'youtube', $volunteering->id);
                            if (isset($activityMediaVideoModel)) {
                                Media::updateActivity($activityMediaVideoModel->id, $volunteering->id, 'youtube', (string)$activity_media_video_url);
                            }
                            #1-images
                            $media_images = $request->file('media_images');
                            Media::saveMultiData($volunteering->id, 'activity', 'image', $media_images);
                        }
                        #end step 1
                        #step 2
                        if (($step === 2 || $step === 5) || ($isDraft && $step >= 2)) {
                            $volunteering->frequency = $request->get('frequency', '');
                            $volunteering->duration = $request->get('duration', 0);
                            $volunteering->volunteer_type = $request->get('volunteering_type', 'regular');
                            $days_of_weeks = $request->get('days_of_week', []);
                            $volunteering->weekday = in_array('WEEKDAY', $days_of_weeks, true) ? 'yes' : 'no';
                            $volunteering->weekend = in_array('WEEKEND', $days_of_weeks, true) ? 'yes' : 'no';
                            #checking date
                            $validator = Validator::make($request->all(), [
                                'commitment_from_date' => 'required|date|date_format:Y-m-d',
                                'commitment_to_date' => 'required|date|date_format:Y-m-d|after:today|after:commitment_from_date',
                                'deadline_for_sign_ups_date' => 'required|date|date_format:Y-m-d|after:today|before:commitment_to_date|after:commitment_from_date'
                            ]);
                            if (!$validator->fails()) {
                                $volunteering->start_date = Helpers::toFormatDateString($request->get('commitment_from_date'), 'Y-m-d H:i:s');
                                $volunteering->end_date = Helpers::toFormatDateString($request->get('commitment_to_date'), 'Y-m-d H:i:s');
                                $volunteering->deadline_sign_ups_date = Helpers::toFormatDateString($request->get('deadline_for_sign_ups_date'), 'Y-m-d H:i:s');
                            }
                            #end checking date
                            $volunteering->town = $request->get('town', '');
                            $volunteering->block_street = $request->get('block_street', '');
                            $volunteering->building_name = $request->building_name;
                            $volunteering->building_unit_number = $request->unit;
                        }
                        #end step 2
                        #step 3
                        if (($step === 3 || $step === 5) || ($isDraft && $step >= 3)) {
                            $volunteering->points_to_note = $request->points_to_note;
                            $volunteering->volunteer_gender = $request->volunteer_gender === 'true' ? 'yes' : 'no';
                            $volunteering->volunteer_contact_phone_number = $request->volunteer_contact_phone_number === 'true' ? 'yes' : 'no';
                            $volunteering->other_response_required = $request->other_response_required;
                            $volunteering->volunteer_signups_confirm = $request->volunteer_signups_confirm === 'true' ? 'yes' : 'no';
                            #step 3 re save
                            $positions = $request->positions;
                            if (is_array($positions)) {
                                VolunteeringActivity::savePositions($volunteering, $positions);
                            }
                        }
                        #end step 3
                        #step 4
                        if (($step === 4 || $step === 5) || ($isDraft && $step >= 4)) {
                            $volunteering->contact_title = $request->get('contact_title', '');
                            $volunteering->contact_name = $request->get('contact_name', '');
                            $volunteering->contact_designation = $request->get('contact_designation', '');
                            $volunteering->contact_phone_number = $request->get('contact_phone_number', '');
                            $volunteering->contact_email = $request->get('contact_email', '');
                        }
                        #end step 4
                        #save data
                        #step 5
                        if ($step === 5 && !$isDraft) {
                            $volunteering->status = 'live';
                        }
                        #end step 5
                        $volunteering->save();//@save volunteering
                        $data = $volunteering;
                    }
                    return response()->json(['success' => true, 'data' => $data]);
                }
                #END UPDATE

                #START DISCARD
                if ($this->actionType === 'discard') {
                    $volunteering = VolunteeringActivity::where('user_id', $user->id)->where('id', $request->id)->where('status', 'draft')->first();
                    $data = $volunteering;
                    if (isset($volunteering)) {
                        #1-causes
                        CauseDetail::saveActivity($volunteering, []);
                        #1-youtube
                        $activityMediaVideoModel = Media::single('activity', 'youtube', $volunteering->id);
                        if (isset($activityMediaVideoModel)) {
                            $activityMediaVideoModel->delete();
                        }
                        #1-images
                        $mediasModel = Media::list('activity', 'image', $volunteering->id, 0, false);
                        foreach ($mediasModel as $mediaModel) {
                            Helpers::removeFile(Media::$uploadPath . $mediaModel->url);
                            $mediaModel->delete();
                        }
                        $volunteering->delete();
                        return response()->json(['success' => true, 'data' => $data]);
                    }
                }
                #END DISCARD
            }
            return response()->json(['success' => false, 'data' => $data]);
        }
    }
}
