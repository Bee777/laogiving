<?php

namespace App\Http\Controllers;


use App\Exports\AllVolunteeringsExport;
use App\Exports\AllVolunteersExport;
use App\Models\Posts;
use App\Models\VolunteeringActivity;
use App\Models\VolunteeringActivityPosition;
use App\Models\VolunteerSignUpActivity;
use App\Responses\Admin\DashboardResponse;
use App\Responses\IndexUserResponse;
use App\Responses\User\UserCredentials;
use App\Responses\User\UserNewsResponse;
use App\Responses\User\UserProfileManage;
use App\Responses\User\UserProfileOptions;
use App\Models\Site;
use App\Responses\User\UserSavedBookmarkResponse;
use App\Responses\User\UserSignUpVolunteeringActivity;
use App\Responses\User\UserVolunteeringActivityManage;
use App\Responses\User\UserVolunteeringActivityManager;
use App\Responses\User\UserVolunteeringActivityOptions;
use App\Responses\User\UserVolunteeringSignUpManage;
use App\Rules\VolunteerPosition;
use App\Traits\UserRoleTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Helpers\Helpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use PDF, Excel;

class UserController extends Controller
{
    use UserRoleTrait;

    protected $rootView = 'main.user';

    protected $maxCauses = 4;
    protected $maxImages = 5;

    protected $excepts = [
        'except' => [
        ]
    ];

    /**
     * @description @ApiMode Only admin, super admin and user can access and do works
     * AdminController constructor.
     */
    public function __construct()
    {
        $this->middleware('api-mode-user-management:super_admin,admin,volunteer,organize', $this->excepts);
    }

    /**
     * @Responses and Actions api|web
     */
    /**
     * @param Request $request
     * @return IndexUserResponse
     */
    public function index(Request $request): IndexUserResponse
    {
        return new IndexUserResponse($this->options($request));
    }

    /**
     * @Responses and Actions api|web
     */

    /****@Responses  api only *** */
    public function me(Request $request)
    {
        $authUser = auth()->user();
        if (!isset($authUser)) {
            return response()->json(['success' => false]);
        }
        return response()->json(['success' => true, 'auth' => $authUser->transformUser()]);
    }

    public function responseActionUserAutoLogin(Request $request)
    {
        $user = $request->user();
        $user->confirmation_code = Str::random(218);
        $user->save();
        $data = route('get.user.UserAutoLogin', $user->confirmation_code);
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function isDownloadableFile($title)
    {
        $allowed = ['excel', 'pdf'];
        return in_array($title, $allowed, true);
    }

    public function download(Request $request, $type)
    {
        $user = $request->user();
        if (!isset($user)) {
            return redirect('/');
        }
        $type = strtolower($type);
        if ($this->isDownloadableFile($type)) {
            return $this->$type($request);
        }
        return redirect('/');
    }

    /***@DownloadResponse */
    public function pdf(Request $request)
    {
        $user = $request->user();
        $export_type = $request->export_type;

        if ($user->isUser('volunteer')) {
            if ($export_type === 'all-sign-up-volunteering') {
                $volunteering_statuses = DB::table('volunteer_sign_up_activities')
                    ->selectRaw("SUM(CASE WHEN volunteer_sign_up_activities.status = 'checkin' and volunteer_sign_up_activities.checkin_date IS NOT NULL THEN 1 ELSE 0 END) AS `CHECKIN_COUNT`,
                SUM(CASE WHEN volunteer_sign_up_activities.status = 'confirm' THEN 1 ELSE 0 END) AS `CONFIRM_COUNT`,
                SUM(CASE WHEN volunteer_sign_up_activities.leader = 'yes' THEN 1 ELSE 0 END) AS `LEADER_COUNT`, 
                SUM(CASE WHEN volunteer_sign_up_activities.status = 'checkin' and volunteer_sign_up_activities.checkin_date IS NOT NULL THEN  volunteer_sign_up_activities.hour_per_volunteer ELSE 0 END) AS `HOURS_COUNT`")
                    ->where('user_id', $user->id)->first();
                $all_sign_up_volunteering = VolunteeringActivity::select([
                    'volunteering_activities.id',
                    'volunteering_activities.name',
                    'volunteer_sign_up_activities.id as sign_up_id',
                    'volunteer_sign_up_activities.slot as sign_up_slot',
                    'volunteer_sign_up_activities.leader as sign_up_leader',
                    'volunteer_sign_up_activities.hour_per_volunteer as sign_up_hour_per_volunteer',
                    'volunteer_sign_up_activities.volunteering_activity_position_id as sign_up_position_id',
                    'volunteer_sign_up_activities.sign_up_date',
                    'users.name as organize_name',
                ])->join('volunteer_sign_up_activities', 'volunteer_sign_up_activities.volunteering_activity_id', '=', 'volunteering_activities.id')
                    ->join('users', 'users.id', 'volunteering_activities.user_id')
                    ->where('volunteer_sign_up_activities.user_id', $user->id)->get();
                $generatePdf = PDF::loadView('generate.users.all-volunteering-signup-pdf', compact('all_sign_up_volunteering', 'request', 'user', 'volunteering_statuses'));
                $fileName = 'all-volunteering-sign-up' . now()->year . '-' . uniqid('all-volunteering-export', true) . '.pdf';
                return $generatePdf->download($fileName);
            }
        }
        return redirect('/');
    }

    public function excel(Request $request)
    {
        $user = $request->user();
        $export_type = $request->export_type;
        if ($user->isUser('organize')) {

            if ($export_type === 'all-sign-up-volunteers') {
                $all_sign_up_volunteers = VolunteerSignUpActivity::select('volunteer_sign_up_activities.*', 'users.name as user_name', 'users.image', 'volunteer_profiles.salutation', 'volunteer_profiles.public_email', 'volunteer_profiles.phone_number',
                    DB::raw('count(volunteer_sign_up_activities.user_id) as  activities_count'),
                    DB::raw("SUM(CASE WHEN volunteer_sign_up_activities.status = 'checkin' and volunteer_sign_up_activities.checkin_date IS NOT NULL THEN volunteer_sign_up_activities.hour_per_volunteer ELSE 0 END) AS `hours_number`"))
                    ->join('volunteering_activities', 'volunteering_activities.id', 'volunteer_sign_up_activities.volunteering_activity_id')
                    ->join('users', 'users.id', 'volunteer_sign_up_activities.user_id')
                    ->leftJoin('volunteer_profiles', 'volunteer_profiles.user_id', 'users.id')
                    ->where('volunteering_activities.user_id', $user->id)
                    ->groupBy('users.id')
                    ->orderBy('users.name', 'asc')
                    ->get();

                $fileName = 'all-volunteers-' . now()->year . '-' . uniqid('all-volunteer-export', true) . '.xlsx';
                $data = [];
                $data['sheet_name'] = 'All volunteers sign up';
                $data['organize'] = $user;
                $data['volunteers'] = $all_sign_up_volunteers;
                $all_sign_up_volunteers_exporter = new AllVolunteersExport($data);
                $all_sign_up_volunteers_exporter->setDatesCoordinate(['B2']);
                $all_sign_up_volunteers_exporter->setTimeCoordinate(['B3']);
                return Excel::download($all_sign_up_volunteers_exporter, $fileName);
            }

            if ($export_type === 'all-sign-up-volunteering') {
                $all_sign_up_volunteerigns = VolunteerSignUpActivity::select('volunteer_sign_up_activities.*', 'users.name as user_name', 'users.image', 'volunteer_profiles.salutation', 'volunteer_profiles.public_email', 'volunteer_profiles.phone_number',
                    DB::raw('count(volunteer_sign_up_activities.user_id) as  activities_count'),
                    DB::raw("SUM(CASE WHEN volunteer_sign_up_activities.status = 'checkin' and volunteer_sign_up_activities.checkin_date IS NOT NULL THEN volunteer_sign_up_activities.hour_per_volunteer ELSE 0 END) AS `hours_number`"))
                    ->join('volunteering_activities', 'volunteering_activities.id', 'volunteer_sign_up_activities.volunteering_activity_id')
                    ->join('users', 'users.id', 'volunteer_sign_up_activities.user_id')
                    ->leftJoin('volunteer_profiles', 'volunteer_profiles.user_id', 'users.id')
                    ->where('volunteering_activities.user_id', $user->id)
                    ->groupBy('users.id')
                    ->orderBy('users.name', 'asc')
                    ->get();

                $activity = VolunteeringActivity::select('volunteering_activities.*')->join('users', 'users.id', 'volunteering_activities.user_id')
                    ->join('user_types', 'user_types.user_id', 'users.id')
                    ->join('organize_profiles', 'organize_profiles.user_id', 'users.id')
                    ->where('user_types.type_user_id', $this->getTypeUserId('organize'))
                    ->where('users.id', $user->id)
                    ->where('volunteering_activities.id', $request->activity_id)->first();

                if (isset($activity)) {
                    $fileName = 'all-volunteering-sign-up-' . now()->year . '-' . uniqid('all-volunteering-export', true) . '.xlsx';
                    $data = [];
                    $data['sheet_name'] = 'All volunteers sign up';
                    $data['organize'] = $user;
                    $data['activity'] = $activity;
                    $data['volunteers'] = $all_sign_up_volunteerigns;
                    $sign_up_activities = VolunteerSignUpActivity::where('volunteering_activity_id', $activity->id)->get();
                    $data['sign_up_activities'] = $sign_up_activities;
                    $all_sign_up_volunteerings_exporter = new AllVolunteeringsExport($data);
                    return Excel::download($all_sign_up_volunteerings_exporter, $fileName);
                }
            }
        } else if ($user->isUser('volunteer')) {

            if ($export_type === 'all-sign-up-volunteering') {
                #check if leader
                $activity = VolunteeringActivity::where('status', 'live')->where('id', $request->activity_id)->first();
                $signUpVolunteeringLeader = VolunteerSignUpActivity::select('volunteer_sign_up_activities.*')
                    ->join('volunteering_activities', 'volunteering_activities.id', 'volunteer_sign_up_activities.volunteering_activity_id')
                    ->where('volunteer_sign_up_activities.user_id', $user->id)
                    ->where('volunteer_sign_up_activities.leader', 'yes')
                    ->where('volunteer_sign_up_activities.volunteering_activity_id', $activity->id ?? 0)->first();

                if (isset($signUpVolunteeringLeader)) {

                    $all_sign_up_volunteerigns = VolunteerSignUpActivity::select('volunteer_sign_up_activities.*', 'users.name as user_name', 'users.image', 'volunteer_profiles.salutation', 'volunteer_profiles.public_email', 'volunteer_profiles.phone_number',
                        DB::raw('count(volunteer_sign_up_activities.user_id) as  activities_count'),
                        DB::raw("SUM(CASE WHEN volunteer_sign_up_activities.status = 'checkin' and volunteer_sign_up_activities.checkin_date IS NOT NULL THEN volunteer_sign_up_activities.hour_per_volunteer ELSE 0 END) AS `hours_number`"))
                        ->join('volunteering_activities', 'volunteering_activities.id', 'volunteer_sign_up_activities.volunteering_activity_id')
                        ->join('users', 'users.id', 'volunteer_sign_up_activities.user_id')
                        ->leftJoin('volunteer_profiles', 'volunteer_profiles.user_id', 'users.id')
                        ->where('volunteering_activities.id', $activity->id)
                        ->where('volunteering_activities.user_id', $activity->user_id)
                        ->groupBy('users.id')
                        ->orderBy('users.name', 'asc')
                        ->get();

                    $activity = VolunteeringActivity::select('volunteering_activities.*')->join('users', 'users.id', 'volunteering_activities.user_id')
                        ->join('user_types', 'user_types.user_id', 'users.id')
                        ->join('organize_profiles', 'organize_profiles.user_id', 'users.id')
                        ->where('user_types.type_user_id', $this->getTypeUserId('organize'))
                        ->where('users.id', $activity->user_id)
                        ->where('volunteering_activities.id', $activity->id)->first();

                    if (isset($activity)) {
                        $fileName = 'all-volunteering-sign-up-' . now()->year . '-' . uniqid('all-volunteering-export', true) . '.xlsx';
                        $data = [];
                        $data['sheet_name'] = 'All volunteers sign up';
                        $data['organize'] = $user;
                        $data['activity'] = $activity;
                        $data['volunteers'] = $all_sign_up_volunteerigns;
                        $sign_up_activities = VolunteerSignUpActivity::where('volunteering_activity_id', $activity->id)->get();
                        $data['sign_up_activities'] = $sign_up_activities;
                        $all_sign_up_volunteerings_exporter = new AllVolunteeringsExport($data);
                        return Excel::download($all_sign_up_volunteerings_exporter, $fileName);
                    }

                }
            }
        }
        return redirect('/');
    }

    /***@DownloadResponse */

    /***@PostsResponse *
     * @param Request $request
     * @param $type
     * @return UserSavedBookmarkResponse
     */
    public function responsePosts(Request $request, $type)
    {
        if ($type === 'saved_bookmark') {
            /****@ResponsesUserSavedBookmark  api and action  *** */
            return new UserSavedBookmarkResponse();
            /****@ResponsesUserSavedBookmark  api and action  *** */
        }
    }

    /***@PostsResponse * */
    public function responseSearches(Request $request, $type): JsonResponse
    {
        $data = [];
        $options = [];

        $paginateLimit = ($request->exists('limit') && !empty($request->get('limit'))) ? $request->get('limit') : 10;
        $paginateLimit = Helpers::isNumber($paginateLimit) ? $paginateLimit : 10;
        $text = $request->get('q');
        $volunteering = $request->get('volunteering', '');

        if ($type === 'news') {
            $data = (new UserNewsResponse('get', ['text' => $text, 'limit' => $paginateLimit]))->get($request);
        } else if ($type === 'volunteering') {
            $user = $request->user('api');

            $data = (new UserVolunteeringActivityManage('get', ['text' => $text, 'limit' => $paginateLimit, 'volunteering' => $volunteering]))->get($request);

            if ($user->isUser('super_admin') || $user->isUser('admin')) {
                $options = [
                    'volunteering_activities' => [
                        'LIVE_COUNT' => 0,
                        'CLOSED_COUNT' => 0,
                        'CANCELLED_COUNT' => 0],
                    'volunteering_statuses' => [
                        'CHECKIN_COUNT' => 0,
                        'CONFIRM_COUNT' => 0,
                        'LEADER_COUNT' => 0,
                        'HOURS_COUNT' => 0
                    ],
                    'LIVE_COUNT' => 0,
                    'CLOSED_COUNT' => 0,
                    'CANCELLED_COUNT' => 0,
                    'DRAFT_COUNT' => 0
                ];
            } else if ($user->isUser('organize')) {
                $options = DB::table('volunteering_activities')
                    ->selectRaw("SUM(CASE WHEN status = 'live' THEN 1 ELSE 0 END) AS `LIVE_COUNT`,
                SUM(CASE WHEN status = 'closed' THEN 1 ELSE 0 END) AS `CLOSED_COUNT`,
                SUM(CASE WHEN status = 'draft' THEN 1 ELSE 0 END) AS `DRAFT_COUNT`,
                SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) AS `CANCELLED_COUNT`")
                    ->where('user_id', $user->id)->first();
            } else {
                $options['volunteering_activities'] = DB::table('volunteering_activities')
                    ->selectRaw("SUM(CASE WHEN volunteering_activities.status = 'live' THEN 1 ELSE 0 END) AS `LIVE_COUNT`,
                SUM(CASE WHEN volunteering_activities.status = 'closed' THEN 1 ELSE 0 END) AS `CLOSED_COUNT`,
                SUM(CASE WHEN volunteering_activities.status = 'cancelled' THEN 1 ELSE 0 END) AS `CANCELLED_COUNT`")
                    ->join('volunteer_sign_up_activities', 'volunteer_sign_up_activities.volunteering_activity_id', '=', 'volunteering_activities.id')
                    ->where('volunteer_sign_up_activities.user_id', $user->id)->first();
                $options['volunteering_statuses'] = DB::table('volunteer_sign_up_activities')
                    ->selectRaw("SUM(CASE WHEN volunteer_sign_up_activities.status = 'checkin' and volunteer_sign_up_activities.checkin_date IS NOT NULL THEN 1 ELSE 0 END) AS `CHECKIN_COUNT`,
                SUM(CASE WHEN volunteer_sign_up_activities.status = 'confirm' THEN 1 ELSE 0 END) AS `CONFIRM_COUNT`,
                SUM(CASE WHEN volunteer_sign_up_activities.leader = 'yes' THEN 1 ELSE 0 END) AS `LEADER_COUNT`, 
                SUM(CASE WHEN volunteer_sign_up_activities.status = 'checkin' and volunteer_sign_up_activities.checkin_date IS NOT NULL THEN  volunteer_sign_up_activities.hour_per_volunteer ELSE 0 END) AS `HOURS_COUNT`")
                    ->where('user_id', $user->id)->first();
            }
        }

        if (count($data) > 0) {
            $data->appends(['limit' => $request->get('limit'), 'q' => $request->get('q'), 'volunteering' => $volunteering]);
        }
        return response()->json(['data' => $data, 'options' => $options]);
    }
    /****@ResponsesSearches api and action  ** */


    /****@ResponsesUserVolunteeringActivity  api and action  *** */
    public function responseVolunteeringActivityOptions(Request $request): UserVolunteeringActivityOptions
    {
        return new UserVolunteeringActivityOptions();
    }

    public function responseVolunteeringActivityCreate(Request $request): UserVolunteeringActivityManage
    {
        $step = (int)$request->step;
        $duplicate_id = $request->get('duplicate');
        $duplicateModel = VolunteeringActivity::find($duplicate_id);
        $isDuplicate = isset($duplicateModel);

        $rule_step_1 = [
            #step 1
            'title' => 'required|max:191',
            'description' => 'required|max:500',
            'causes' => 'required|array',
            'media_video_url' => 'string|max:191',
            'media_images' => 'required|array',
            'media_images.*' => $isDuplicate ? '' : 'required|max:3000|mimes:jpeg,png,jpg,gif,svg'
        ];

        $rule_step_2 = [
            #step 2
            'frequency' => ['required', 'max:191', Rule::in($this->getFrequencies())],
            'duration' => 'required|min:1|max:24|numeric',
            'days_of_week' => ['required', 'array', Rule::in($this->getDaysOfWeek())],
            'volunteering_type' => ['required', 'max:191', Rule::in($this->getVolunteerTypes())],
            'commitment_from_date' => 'required|date|date_format:Y-m-d',
            'commitment_to_date' => 'required|date|date_format:Y-m-d|after:today|after:commitment_from_date',
            'deadline_for_sign_ups_date' => 'required|date|date_format:Y-m-d|after:today|before:commitment_to_date|after:commitment_from_date',
            'town' => 'required|max:191',
            'block_street' => 'required|max:191',
            'building_name' => 'max:191',
            'unit' => 'max:191'
        ];

        $rule_step_3 = [
            #step 3
            'positions' => ['required', 'array'],
            'positions.*' => ['required', new VolunteerPosition()],
            'points_to_note' => 'max:500',
            'volunteer_gender' => 'max:191',
            'volunteer_contact_phone_number' => 'max:191',
            'other_response_required' => 'max:191',
            'volunteer_signups_confirm' => 'max:191'
        ];

        $rule_step_4 = [
            #step 4
            'contact_title' => ['required', 'max:191', Rule::in($this->getSalutations())],
            'contact_name' => 'required|max:191',
            'contact_designation' => 'required|max:191',
            'contact_phone_number' => 'required|max:191',
            'contact_email' => 'required|email|max:191'
        ];
        $rules = [];
        if ($this->checkSteps($step)) {
            $rule_step = 'rule_step_' . $step;
            $rules = $$rule_step;
        } else {
            $rules = array_merge($rule_step_2, $rule_step_3, $rule_step_4);
            $request->request->set('step', 5);
        }
        $this->validate($request, array_merge($rule_step_1, $rules));
        if ($step >= 4 && !Helpers::isValidPhoneNumber($request->get('contact_phone_number'))) {
            return response()->json(['errors' => ['contact_phone_number' => ['Your contact phone number is invalid.']]], 422);
        }
        $causes = $request->get('causes', []);
        $media_images = $request->file('media_images', []);

        if (count($causes) > $this->maxCauses) {
            return response()->json(['errors' => ['causes' => ['Your causes is invalid.']]], 422);
        }
        if (count($media_images) > $this->maxImages) {
            return response()->json(['errors' => ['media_images' => ['Your media images is invalid.']]], 422);
        }
        return new UserVolunteeringActivityManage('create');
    }

    public function responseVolunteeringActivityUpdate(Request $request, $id)
    {

        $step = (int)$request->step;
        $rule_step_1 = [
            #step 1
            'title' => 'required|max:191',
            'description' => 'required|max:500',
            'causes' => 'required|array',
            'media_video_url' => 'string|max:191',
            'media_images' => 'required|array',
            'user_media_images_cleared' => 'array'
        ];
        $rule_step_2 = [
            #step 2
            'frequency' => ['required', 'max:191', Rule::in($this->getFrequencies())],
            'duration' => 'required|min:1|max:24|numeric',
            'days_of_week' => ['required', 'array', Rule::in($this->getDaysOfWeek())],
            'volunteering_type' => ['required', 'max:191', Rule::in($this->getVolunteerTypes())],
            'commitment_from_date' => 'required|date|date_format:Y-m-d',
            'commitment_to_date' => 'required|date|date_format:Y-m-d|after:commitment_from_date',
            'deadline_for_sign_ups_date' => 'required|date|date_format:Y-m-d|before:commitment_to_date|after:commitment_from_date',
            'town' => 'required|max:191',
            'block_street' => 'required|max:191',
            'building_name' => 'max:191',
            'unit' => 'max:191'
        ];
        $rule_step_3 = [
            #step 3
            'positions' => ['required', 'array'],
            'positions.*' => ['required', new VolunteerPosition()],
            'points_to_note' => 'max:500',
            'volunteer_gender' => 'max:191',
            'volunteer_contact_phone_number' => 'max:191',
            'other_response_required' => 'max:191',
            'volunteer_signups_confirm' => 'max:191'
        ];
        $rule_step_4 = [
            #step 4
            'contact_title' => ['required', 'max:191', Rule::in($this->getSalutations())],
            'contact_name' => 'required|max:191',
            'contact_designation' => 'required|max:191',
            'contact_phone_number' => 'required|max:191',
            'contact_email' => 'required|email|max:191',
        ];
        $rule = [];
        if ($this->checkSteps($step)) {
            $rule_step = 'rule_step_' . $step;
            $rule = $$rule_step;
        } else {
            $rule = array_merge($rule_step_2, $rule_step_3, $rule_step_4);
            $step = 5;
            $request->request->set('step', 5);
        }
        $this->validate($request, array_merge($rule_step_1, $rule));

        if ($step >= 4 && !Helpers::isValidPhoneNumber($request->get('contact_phone_number'))) {
            return response()->json(['errors' => ['contact_phone_number' => ['Your contact phone number is invalid.']]], 422);
        }

        $causes = $request->get('causes', []);
        $media_images = $request->file('media_images', []);

        if (count($causes) > $this->maxCauses) {
            return response()->json(['errors' => ['causes' => ['Your causes is invalid.']]], 422);
        }
        if (count($media_images) > $this->maxImages) {
            return response()->json(['errors' => ['media_images' => ['Your media images is invalid.']]], 422);
        }

        return new UserVolunteeringActivityManage('update');
    }

    public function responseVolunteeringActivityDiscard(Request $request, $id)
    {
        return new UserVolunteeringActivityManage('discard');
    }
    /****@ResponsesUserVolunteeringActivity  api and action  *** */
    /****@responseVolunteeringActivityManager  api and action  *** */
    public function responseVolunteeringActivityManager(Request $request, $id)
    {
        return new UserVolunteeringActivityManager();
    }

    public function responseVolunteeringActivityManagerChangeStatus(Request $request, $id)
    {
        $data = $this->validate($request, [
            'status' => 'required|max:191',
        ]);
        $user = $request->user('api');

        if ($user->isUser('organize')) {
            $volunteerActivity = VolunteeringActivity::where('user_id', $user->id)->where('id', $id)->first();
            if (isset($volunteerActivity) && $volunteerActivity->status === 'live') {
                if ($data['status'] === 'close') {
                    $volunteerActivity->status = 'closed';
                } else if ($data['status'] === 'cancel') {
                    $volunteerActivity->status = 'cancelled';
                }
                $volunteerActivity->save();
                return response()->json(['success' => true, 'msg' => 'The activity status was successfully changed!']);
            }
        } else if ($user->isUser('volunteer')) {
            $volunteerActivity = VolunteeringActivity::where('status', 'live')->where('id', $id)->first();
            $signUpVolunteeringLeader = VolunteerSignUpActivity::select('volunteer_sign_up_activities.*')
                ->join('volunteering_activities', 'volunteering_activities.id', 'volunteer_sign_up_activities.volunteering_activity_id')
                ->where('volunteer_sign_up_activities.user_id', $user->id)
                ->where('volunteer_sign_up_activities.leader', 'yes')
                ->where('volunteer_sign_up_activities.volunteering_activity_id', $volunteerActivity->id ?? 0)->first();
            if (isset($volunteerActivity, $signUpVolunteeringLeader) && $volunteerActivity->status === 'live') {
                if ($data['status'] === 'close') {
                    $volunteerActivity->status = 'closed';
                } else if ($data['status'] === 'cancel') {
                    $volunteerActivity->status = 'cancelled';
                }
                $volunteerActivity->save();
                return response()->json(['success' => true, 'msg' => 'The activity status was successfully changed!']);
            }
        }
        return response()->json(['success' => false, 'msg' => 'Failed to change the activity status!']);
    }
    /****@responseVolunteeringActivityManager  api and action  *** */

    /****@responseVolunteeringSignUpManage  api and action  *** */
    public function responseVolunteeringSignUpChangeStatus(Request $request, $id)
    {
        return new UserVolunteeringSignUpManage('change-status', ['single' => true]);
    }

    public function responseAllVolunteeringSignUpChangeStatus(Request $request)
    {
        return new UserVolunteeringSignUpManage('change-status', ['single' => false]);
    }

    public function responseAllVolunteeringSignUpChangeAttendance(Request $request)
    {
        return new UserVolunteeringSignUpManage('change-attendance');
    }

    public function responseFetchAllSignUpVolunteers(Request $request)
    {
        return new UserVolunteeringSignUpManage('fetch-all-volunteers');
    }
    /****@responseVolunteeringSignUpManage  api and action  *** */

    /****@ResponsesUserProfile  api and action  *** */
    public function responseProfileOptions(Request $request): UserProfileOptions
    {
        return new UserProfileOptions();
    }

    public function responseVisibilityProfileManage(Request $request)
    {
        $this->validate($request, [
            'visibility' => 'required|max:30']);
        $user = $request->user();
        if ($user->isUser('organize')) {
            $data = $request->get('visibility');
            if ((new UserProfileManage($request))->visibility($data)) {
                $userProfile = $user->userProfile('organize');
                if (isset($userProfile)) {
                    $userProfile->visibility = $data;
                    $userProfile->save();
                    return response()->json(['success' => true,
                        'msg' => 'You are ' . $data . ' your organisation profile.',
                        'data' => route('get.home.organize.profile', $user->id)]);
                    //"You are not allowed to hide your organisation profile as you have active campaigns with donations or volunteer activities with sign ups."
                }
                return response()->json(['success' => false, 'msg' => 'Setting up your account in Account tab first.']);
            }
        }
        return response()->json(['success' => false, 'msg' => 'Invalid data input.']);
    }

    public function responseProfileManage(Request $request): UserProfileManage
    {

        if ($request->user()->isUser('organize')) {
            $rules = [
                'user_causes' => 'required',
                'contact_person' => 'max:191',
                'facebook' => 'max:191',
                'website' => 'max:191',
                'about' => 'max:1500',
            ];
        } else {
            $rules = [];
        }
        $this->validate($request, array_merge($rules, [
            'profile_image' => 'max:3000|mimes:jpeg,png,jpg,gif,svg',
            'display_name' => 'required|string|max:191',
            'public_email' => 'email|max:191',
            'phone_number' => 'max:191',
        ]));

        $causes = $request->get('user_causes', []);
        $media_images = $request->file('user_media_images', []);

        if (count($causes) > $this->maxCauses) {
            return response()->json(['errors' => ['user_causes' => ['Your causes is invalid.']]], 422);
        }
        if (count($media_images) > $this->maxImages) {
            return response()->json(['errors' => ['user_media_images' => ['Your media images is invalid.']]], 422);
        }

        return new UserProfileManage($request);
    }

    /****@ResponsesUserProfile  api and action  *** */

    /****@ResponsesUserCredentials  api and action  *** */

    public function responseCredentialsManage(Request $request)
    {

        $this->validate($request, ['current_password' => 'required|min:6|max:191']);

        $user = User::find(auth()->user()->id);//current user

        if ($this->isNeedToValidate($request, 'new_email')) {
            $this->validate($request, ['new_email' => 'email|max:191']);
            if ($this->userExists($request->get('new_email'))) {
                return response()->json(['errors' => ['new_email' => ['Your entered email already exists in our system.']]], 422);
            }
        }

        if ($this->isNeedToValidate($request, 'new_password')) {
            $this->validate($request, [
                'new_password' => 'confirmed|min:8|max:191|different:current_password',
                'password_confirmation' => 'min:8|max:191'
            ]);
        }

        if (!(isset($user) && Hash::check($request->get('current_password'), $user->password))) {
            return response()->json(['errors' => ['current_password' => ['Your entered current password is not match your current password.']]], 422);
        }
        //check if enter current password matched the current password
        return new UserCredentials($user);
    }

    public function isNeedToValidate($request, $name)
    {
        return $request->has($name) && $request->get($name) !== null && !empty($request->get($name));
    }
    /****@EndResponsesUserCredentials  api and action  *** */

    /****@ResponsesDashboardData  api and action  *** */

    public function responseDashboardData(Request $request): DashboardResponse
    {
        return new DashboardResponse();
    }
    /****@ResponsesDashboardData  api and action  *** */


    /*** @postManagePostsStatus * */
    public function responseActionManagePostsStatus(Request $request)
    {
        $data = $this->validate($request, [
            'id' => 'required|max:191',
            'changeStatusTo' => 'required|max:191',
        ]);
        $info = Posts::where('id', $data['id'])->where('user_id', auth()->user()->id)->first();
        if (isset($info)) {
            if ($info->status === 'open' && $data['changeStatusTo'] === 'close') {
                $info->status = 'close';
            } else if ($info->status === 'close' && $data['changeStatusTo'] === 'open') {
                //check if post type is event or scholarship
                if ($info->type === 'event') {//set new dates for expired post
                    $this->validate($request, [
                        'start_event' => 'required',
                        'end_event' => 'required',
                    ]);
                    $info->start_date = Helpers::toFormatDateString($request->get('start_event'), 'Y-m-d H:i:s');
                    $info->deadline = Helpers::toFormatDateString($request->get('end_event'), 'Y-m-d H:i:s');
                } else if ($info->type === 'scholarship') {//set new date for expired post
                    $this->validate($request, [
                        'scholarship_deadline' => 'required',
                    ]);
                    $info->deadline = Helpers::toFormatDateString($request->get('scholarship_deadline'), 'Y-m-d H:i:s');
                }
                $info->status = 'open';
            }
            $info->save();
            return response()->json(['success' => true, 'msg' => 'The post status was successfully changed!']);
        }
        return response()->json(['success' => false, 'msg' => 'Failed to change the post status!']);
    }
    /*** @postManagePostsStatus * */

    /*** @postSaveSignUpVolunteering * */
    public function responsePostSaveSignUpVolunteering(Request $request)
    {
        $user = $request->user('api');
        if ($user->status !== 'approved' || !$user->isUser('volunteer')) {
            return response()->json(['errors' => ['sign_up_not_valid' => ['You don\'t have permission to signup this volunteer activity.']]], 422);
        }
        $activity = VolunteeringActivity::select('volunteering_activities.*')->join('users', 'users.id', 'volunteering_activities.user_id')
            ->join('user_types', 'user_types.user_id', 'users.id')
            ->join('organize_profiles', 'organize_profiles.user_id', 'users.id')
            ->where('user_types.type_user_id', $this->getTypeUserId('organize'))
            ->where('volunteering_activities.status', 'live')
            ->where('users.status', 'approved')
            ->where('volunteering_activities.id', $request->activity_id)->first();

        if (isset($activity)) {
            $hourDiff = Helpers::diffInHours($activity->deadline_sign_ups_date, now());
            #If the activity has reached the deadline date.
            if ($hourDiff < 0) {
                return response()->json(['errors' => ['sign_up_not_valid' => ['You don\'t have permission to signup this volunteer activity.']]], 422);
            }
            # If already signed-up for the  activity.
            $sign_up_exists = VolunteerSignUpActivity::where('volunteering_activity_id', $activity->id)->where('user_id', $user->id)->exists();
            if ($sign_up_exists) {
                return response()->json(['errors' => ['sign_up_not_valid' => ['You have already signed-up for this activity.']]], 422);
            }
            # If the amount of selected confirmed position vacancies already full
            $position_vacancies = VolunteeringActivityPosition::where('volunteering_activity_id', $activity->id)->where('id', $request->volunteer_position)->first();
            if (!isset($position_vacancies)) {
                return response()->json(['errors' => ['sign_up_not_valid' => ['You don\'t have permission to signup this volunteer activity.']]], 422);
            }
            $vacancies = VolunteerSignUpActivity::getSignUpPositionCount($activity->id, $position_vacancies->id);
            if ($vacancies + 1 > $position_vacancies->vacancies) {
                return response()->json(['errors' => ['sign_up_not_valid' => ['The position vacancies already full.']]], 422);
            }
            $rules = [];
            # - Validate minimum age of the selected position if minimum age not empty.
            if ($position_vacancies->minimum_age && $position_vacancies->minimum_age > 12) {
                $your_date_of_birth = $request->your_date_of_birth;
                $your_minimum_age = Helpers::getAge($your_date_of_birth);
                $rules = ['your_date_of_birth' => ['before:today']];
                if ($position_vacancies->minimum_age > $your_minimum_age) {
                    return response()->json(['errors' => ['your_minimum_age' => ["Your minimum age is {$position_vacancies->minimum_age}."]]], 422);
                }
            }
            # - Validate contact phone number if it set to yes for required to fill.
            if ($activity->volunteer_contact_phone_number === 'yes') {
                $rules = array_merge(['volunteer_contact_phone_number' => ['required', 'max:191']], $rules);
            }
            # - Validate other response if it set to yes for required to fill.
            if ($activity->other_response_required !== null && $activity->other_response_required !== '') {
                $rules = array_merge(['other_response_answer' => ['required', 'max:191']], $rules);
            }
            # Validate with all default form and selected position required
            $this->validate($request, array_merge([
                'volunteer_position' => 'required',
            ], $rules));

            if ($activity->volunteer_contact_phone_number === 'yes' && !Helpers::isValidPhoneNumber($request->get('volunteer_contact_phone_number'))) {
                return response()->json(['errors' => ['volunteer_contact_phone_number' => ['Your contact phone number is invalid.']]], 422);
            }
            return new UserSignUpVolunteeringActivity($activity);
        }
        return response()->json(['errors' => ['sign_up_not_valid' => ['The volunteer activity does not exists or draft, cancelled or even closed.']]], 422);
    }

    /*** @postSaveSignUpVolunteering * */
    public function responseFetchSignUpVolunteeringSuccess(Request $request, $activity_id)
    {
        $activity = VolunteeringActivity::select('volunteering_activities.*')->join('users', 'users.id', 'volunteering_activities.user_id')
            ->join('user_types', 'user_types.user_id', 'users.id')
            ->join('organize_profiles', 'organize_profiles.user_id', 'users.id')
            ->where('user_types.type_user_id', $this->getTypeUserId('organize'))
            ->whereIn('volunteering_activities.status', ['live', 'closed', 'cancelled'])
            ->where('users.status', 'approved')
            ->where('volunteering_activities.id', $activity_id)->first();

        if (isset($activity)) {
            $user = $request->user('api');
            $sign_up_activity = VolunteerSignUpActivity::where('volunteering_activity_id', $activity->id)->where('user_id', $user->id)->first();
            $data = [];
            $data['sign_up'] = VolunteerSignUpActivity::mapData($sign_up_activity, $activity->volunteer_gender === 'yes');
            return response()->json(['success' => true, 'data' => $data]);
        }
        return response()->json(['errors' => ['data_not_valid' => ['The volunteer activity does not exists.']]], 422);
    }

    /**
     * @Responses api only
     */

    /**
     * @Helper helper functions
     */

    /**
     * @return array
     */
    public function getSettings(): array
    {
        $settings = Site::select('id', 'key', 'value')
            ->whereNotIn('key', [])->get();
        $s = [];
        foreach ($settings as $setting) {
            $s[$setting->key] = $setting->value;
        }
        return $s;
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function options(Request $request): array
    {
        return [
            'settings' => $this->getSettings(),
            'rootView' => $this->rootView,
        ];
    }

    public static function isEngText($text): bool
    {
        return (strlen($text) === strlen(utf8_decode($text))); // is english
    }

    private function userExists($email): bool
    {
        $user = User::where('email', $email)->first();
        return isset($user);
    }

    public function getFrequencies(): array
    {
        return [
            '1_DAY_PER_WEEK',
            '2_3_DAYS_PER_WEEK',
            'FORTNIGHTLY',
            'MONTHLY',
            'QUARTERLY',
            'FLEXIBLE',
            'FULL_TIME',
        ];
    }

    public function getDaysOfWeek(): array
    {
        return [
            'WEEKDAY',
            'WEEKEND'
        ];
    }

    private function getVolunteerTypes()
    {
        return [
            'regular',
            'ad-hoc'
        ];
    }

    public function getSalutations()
    {
        return [
            'mr', 'ms', 'mrs', 'miss', 'mdm', 'dr'
        ];
    }

    public function checkSteps(int $step)
    {
        $steps = [1, 2, 3, 4];
        return in_array($step, $steps, true);
    }
    /**
     * @Helper helper functions
     */
}
