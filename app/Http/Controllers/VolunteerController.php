<?php

namespace App\Http\Controllers;

use App\Responses\Volunteer\IndexVolunteerResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Helpers\Helpers;
use Illuminate\Http\JsonResponse;
use App\User;
use App\Models\Site;
use Illuminate\Support\Facades\Hash;

class VolunteerController extends Controller
{
    protected $rootView = 'main.volunteer';

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
        $this->middleware('api-mode-user-management:super_admin,admin,volunteer', $this->excepts);
    }

    /**
     * @Responses and Actions api|web
     */
    /**
     * @param Request $request
     * @return IndexVolunteerResponse
     */
    public function index(Request $request): IndexVolunteerResponse
    {
        return new IndexVolunteerResponse($this->options($request));
    }

    /**
     * @Responses and Actions api|web
     */

    /****@Responses  api only ** */

    /****@Responses  end api only ** */

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
