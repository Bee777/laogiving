<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 3/2/2019
 * Time: 2:46 PM
 */

namespace App\Responses\Admin;

use App\Http\Controllers\Helpers\Helpers;
use App\Models\Posts;
use App\Traits\UserRoleTrait;
use App\User;
use Illuminate\Contracts\Support\Responsable;

class DashboardResponse implements Responsable
{
    use UserRoleTrait;

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        if (Helpers::isAjax($request)) {
            $data = [];
            $data['latest_members_count'] = User::join('user_types', 'user_types.user_id', 'users.id')->whereIn('user_types.type_user_id', User::getNonAdminUserIds())->count();
            $data['news_count'] = $this->getPostsCount('news')['all'];

            if (User::isAdminUser($request->user())) {
                $data['activities_count'] = ['active' => 0, 'all' => 0, 'success' => 0];
                $data['volunteering_hours'] = 0;
                $data['latest_volunteers_count'] = User::join('user_types', 'user_types.user_id', 'users.id')->where('user_types.type_user_id', $this->getTypeUserId('volunteer'))->count();
                $data['latest_organizes_count'] = User::join('user_types', 'user_types.user_id', 'users.id')->where('user_types.type_user_id', $this->getTypeUserId('organize'))->count();
            }
            return response()->json(['data' => $data]);
        }
    }

    public function getPostsCount($type): array
    {
        $data = [];
        $data['active'] = Posts::where('type', $type)->where('status', 'open')->count();
        $data['all'] = Posts::where('type', $type)->count();
        return $data;
    }
}
