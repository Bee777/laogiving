<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 5/12/2019
 * Time: 8:37 AM
 */

namespace App\Http\Controllers;

use App\Responses\Organize\IndexOrganizeResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Helpers\Helpers;
use Illuminate\Http\JsonResponse;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Site;

class OrganizeController extends Controller
{
    protected $rootView = 'main.organize';

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
        $this->middleware('api-mode-user-management:super_admin,admin,organize', $this->excepts);
    }

    /**
     * @Responses and Actions api|web
     */
    /**
     * @param Request $request
     * @return IndexOrganizeResponse
     */
    public function index(Request $request): IndexOrganizeResponse
    {
        return new IndexOrganizeResponse($this->options($request));
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
