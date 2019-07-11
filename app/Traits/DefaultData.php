<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 3/7/2019
 * Time: 4:29 PM
 */

namespace App\Traits;

use App\Models\Banner;
use App\Models\Cause;
use App\Models\Posts;
use App\Models\Skill;
use App\Models\Suitable;
use App\Responses\Home\PostsResponse;
use App\Models\Site;
use App\User;
use Illuminate\Http\Request;

trait DefaultData
{
    use UserRoleTrait;

    public function getDefaultData(Request $request): array
    {
        $request->request->set('limit', 3);
        return [
            's' => $this->getSettings(),
            'states' => json_encode($this->getStates()),
            'banners' => json_encode(Banner::getBanners(3)),
            'latest_news' => json_encode(Posts::getPosts('news', 3)),
            'news' => json_encode((new PostsResponse([], 'news'))->postsPaginator($request)),
            'activities' => json_encode((new PostsResponse([], 'activities'))->postsPaginator($request)),
            'all_causes' => json_encode(Cause::getCauses('all')),
            'all_suitables' => json_encode(Skill::getSkills('all')),
            'all_skills' => json_encode(Suitable::getSuitables('all')),
        ];
    }

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

    public function getStates(): array
    {
        $data = [];
        $data['volunteer_signups'] = User::join('user_types', 'user_types.user_id', 'users.id')->where('user_types.type_user_id', $this->getTypeUserId('volunteer'))->where('users.status', 'approved')->get()->count();
        $data['volunteering_created'] = User::join('user_types', 'user_types.user_id', 'users.id')
            ->where('user_types.type_user_id', $this->getTypeUserId('organize'))
            ->join('volunteering_activities', 'volunteering_activities.user_id', 'users.id')
            ->where('users.status', 'approved')
            ->whereIn('volunteering_activities.status', ['live', 'closed'])->get()->count();

        return $data;
    }
}
