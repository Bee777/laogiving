<?php

namespace App\Http\Controllers;


use App\Models\Posts;
use App\Responses\Admin\DashboardResponse;
use App\Responses\IndexUserResponse;
use App\Responses\User\UserCredentials;
use App\Responses\User\UserNewsResponse;
use App\Responses\User\UserProfileManage;
use App\Responses\User\UserProfileOptions;
use App\Responses\User\UserProfileSingle;
use App\Models\Site;
use Illuminate\Http\Request;
use App\Http\Controllers\Helpers\Helpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    protected $rootView = 'main.user';

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
        $user->confirmation_code = encrypt(Str::random() . $user->id);
        $user->save();
        $data = route('get.user.UserAutoLogin', $user->confirmation_code);
        return response()->json(['success' => true, 'data' => $data]);
    }

    /****@ResponsesSearches api and action  *** */
    /**
     * @param Request $request
     * @param $type
     * @return \Illuminate\Http\JsonResponse
     */

    public function responseSearches(Request $request, $type): JsonResponse
    {
        $data = [];
        $paginateLimit = ($request->exists('limit') && !empty($request->get('limit'))) ? $request->get('limit') : 10;
        $paginateLimit = Helpers::isNumber($paginateLimit) ? $paginateLimit : 10;
        $text = $request->get('q');

        if ($type === 'news') {
            $data = (new UserNewsResponse('get', ['text' => $text, 'limit' => $paginateLimit]))->get($request);
        }
        if (count($data) > 0) {
            $data->appends(['limit' => $request->exists('limit'), 'q' => $request->get('q')]);
        }
        return response()->json(['data' => $data]);
    }
    /****@ResponsesSearches api and action  ** */

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

    /****@ResponsesUserProfileSingle  api and action  *** */
    public function responseUserProfileSingle(Request $request, $user_id): UserProfileSingle
    {
        return new UserProfileSingle($user_id);
    }
    /****@EndResponsesUserProfileSingle  api and action  *** */

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

    /**
     * @Helper helper functions
     */
}
