<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 3/3/2019
 * Time: 11:33 AM
 */

namespace App\Responses\Home;

use App\Http\Controllers\Helpers\Helpers;
use App\Models\CauseDetail;
use App\Models\Media;
use App\Models\Posts;
use App\Models\UserSaved;
use App\Models\VolunteeringActivity;
use App\Models\VolunteerSignUpActivity;
use App\Traits\DefaultData;
use Illuminate\Contracts\Support\Responsable;

class SinglePostsResponse implements Responsable
{
    use DefaultData;

    protected $options = [];
    protected $type = '';
    protected $id;

    public function __construct($options, $type, $id)
    {
        $this->options = $options;
        $this->type = $type;
        $this->id = $id;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response | mixed
     */
    public function toResponse($request)
    {
        $type = $this->getPostsType($this->type);
        $post = Posts::where('type', $type)->whereIn('status', ['open', 'close'])->where('id', $this->id)->first();
        $post_type_name = ucfirst($this->type);
        $user = $request->user('api');
        $view_by_owner = false;
        //@for checking volunteering
        if ($type === 'activity') {
            #check if an organize viewing
            $withUserStatus = 'approved';
            $withUserActivityStatus = [];
            if (isset($user)) {
                #check if organize
                $self_post_user = VolunteeringActivity::where('id', $this->id)->where('user_id', $user->id)->exists();
                if ($self_post_user && $user->isUser('organize')) {
                    $withUserStatus = $user->status;
                    $withUserActivityStatus = ['draft', 'closed', 'cancelled'];
                    $view_by_owner = true;
                }
                #check if volunteer
                $already_sign_up = VolunteerSignUpActivity::where('volunteering_activity_id', $this->id)->where('user_id', $user->id)->exists();
                if ($already_sign_up && $user->isUser('volunteer')) {
                    $withUserActivityStatus = ['closed', 'cancelled'];
                }
            }
            $post = VolunteeringActivity::select('volunteering_activities.*', 'users.name as organize_name', 'users.image as organize_image', 'organize_profiles.visibility')
                ->join('users', 'users.id', 'volunteering_activities.user_id')
                ->join('user_types', 'user_types.user_id', 'users.id')
                ->join('organize_profiles', 'organize_profiles.user_id', 'users.id')
                ->where('user_types.type_user_id', $this->getTypeUserId('organize'))
                ->whereIn('volunteering_activities.status', array_merge(['live'], $withUserActivityStatus))
                ->where('users.status', $withUserStatus)
                ->where('volunteering_activities.id', $this->id)->first();
        }
        //@end for checking volunteering
        if (Helpers::isAjax($request)) {
            if (!isset($post)) {
                return response()->json(['success' => false, 'msg' => 'The post does not exits!.']);
            }
            //@for volunteering
            if ($type === 'activity') {
                return $this->getVolunteering($post, $user, $view_by_owner);
            }
            //@for volunteering

            //@other posts type
            Posts::IncreaseViews($post->id);
            return $this->postsPaginator($request);
        }
        if (empty($type)) {
            return redirect('/');
        }
        if (!isset($post)) {
            return redirect('/');
        }
        Posts::IncreaseViews($post->id);
        return view("{$this->options['rootView']}.single.single-posts",
            array_merge(['post_type_name' => $post_type_name, 'type' => $this->type, 'post' => $post], $this->getDefaultData($request)));
    }

    public function getVolunteering($post, $user, $view_by_owner)
    {
        //@for volunteering
        #user saved bookmark
        if (isset($user)) {
            $post->saved_bookmark = UserSaved::where('post_id', $post->id)->where('user_id', $user->id)
                ->where('type', 'activity')->exists();
            $post->already_sign_up = VolunteerSignUpActivity::where('volunteering_activity_id', $post->id)->where('user_id', $user->id)->exists();
            $post->view_by_owner = $view_by_owner;
            $post->view_by_admin = ($user->isUser('admin') || $user->isUser('super_admin'));
            #cehck if conflicts with another
            if (!$post->already_sign_up) {
                $post->conflicts_with_another = VolunteerSignUpActivity::isConflictsSignUpActivity($post, $user->id);
            } else {
                $post->conflicts_with_another = false;
            }
        }
        #check can sign up
        if (isset($post->deadline_sign_ups_date)) {
            $hourDiff = Helpers::diffInHours($post->deadline_sign_ups_date, now());
            $post->can_sign_up = $hourDiff > 0;
        }
        #user image
        $post->organize_image = "/assets/images/user_profiles/{$post->organize_image}";
        #format date
        $post->start_date_formatted = Helpers::toFormatDateString($post->start_date, 'D, d M Y');
        $post->end_date_formatted = Helpers::toFormatDateString($post->end_date, 'D, d M Y');
        $post->deadline_sign_ups_date_formatted = Helpers::toFormatDateString($post->deadline_sign_ups_date, 'd M Y, H:i A');
        $post->start_date_formatted_number = Helpers::toFormatDateString($post->start_date, 'd M Y');
        $post->end_date_formatted_number = Helpers::toFormatDateString($post->end_date, 'd M Y');
        #causes
        $post->activity_causes = CauseDetail::list('activity', $post->id)->pluck('cause_id');
        $activity_causes = CauseDetail::list('activity', $post->id);
        $activity_causes->map(function ($item) {
            $item->cause_data = $item->cause;
            return $item;
        });
        $post->activity_causes_display = $activity_causes->pluck('cause_data');
        $activityMediaVideo = Media::single('activity', 'youtube', $post->id);
        $post->video_media = $activityMediaVideo ?? ['validated' => '', 'url' => ''];
        $activityMediaImages = Media::list('activity', 'image', $post->id);
        if (count($activityMediaImages) > 0) {
            $post->images_media = $activityMediaImages;
        } else {
            $post->images_media = [
                [
                    'image_base64' => '',
                    'image' => null,
                    'validated' => '',
                    'removable' => false
                ]
            ];
        }
        $days_of_week = [];
        if ($post->weekday === 'yes') {
            $days_of_week[] = 'WEEKDAY';
        }
        if ($post->weekend === 'yes') {
            $days_of_week[] = 'WEEKEND';
        }
        $post->days_of_week = $days_of_week;
        $post->positions = $post->positionsMap();
        #volunteering status
        $post->volunteers_confirm = 0;
        $post->volunteers_pending = 0;

        #others volunteering
        $fields = [
            'users.name as organize',
            'volunteering_activities.name',
            'volunteering_activities.description',
            'volunteering_activities.duration',
            'volunteering_activities.start_date',
            'volunteering_activities.end_date',
            'volunteering_activities.deadline_sign_ups_date',
            'volunteering_activities.town',
            'volunteering_activities.block_street',
            'volunteering_activities.building_name',
            'volunteering_activities.building_unit_number',
            'volunteering_activities.created_at',
            'volunteering_activities.updated_at'];
        #others
        $data = VolunteeringActivity::select(array_merge($fields, [
            'volunteering_activities.id',
            'volunteering_activities.frequency',
            'volunteering_activities.weekday',
            'volunteering_activities.weekend',
            'volunteering_activities.status',
        ]))->join('users', 'users.id', 'volunteering_activities.user_id')
            ->join('user_types', 'user_types.user_id', 'users.id')
            ->where('user_types.type_user_id', $this->getTypeUserId('organize'))
            ->where('volunteering_activities.status', 'live')
            ->where('users.status', 'approved')
            ->where('volunteering_activities.id', '!=', $this->id);
        #set others data
        $data = $data->orderBy('id', 'desc')->limit(6)->inRandomOrder()->get();
        #map others data
        $data->map(function ($activity) {
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
            $activity->days_of_week = $days_of_week;
            $activity->positions = $activity->positionsMap();
            #date map
            $activity->start_date_formatted = Helpers::toFormatDateString($activity->start_date, 'd/m/Y');
            $activity->end_date_formatted = Helpers::toFormatDateString($activity->end_date, 'd/m/Y');
            $activity->deadline_sign_ups_date_formatted = Helpers::toFormatDateString($activity->deadline_sign_ups_date, 'd/m/Y');
        });
        return ['data' => $post, 'others' => $data];
        //@for volunteering
    }

    public function postsPaginator($request): array
    {
        $type = $this->getPostsType($this->type);

        $fields = ['id', 'title', 'type', 'image', 'description', 'status', 'place', 'hosted_by', 'start_date', 'deadline', 'updated_at', 'user_id',];
        $data = Posts::select($fields)->where('type', $type)->whereIn('status', ['open', 'close'])->where('id', $this->id)->first();

        $this->mapPost($data);
        $others = Posts::select($fields)->where('type', $type)->whereIn('status', ['open', 'close'])
            ->limit(3)->where('id', '!=', $this->id)->inRandomOrder()->get();
        $this->mapPosts($others);
        return ['data' => $data, 'others' => $others];
    }

    public function getPostsType($title)
    {
        $types = [
            'activities' => 'activity', 'news' => 'news',
            'events' => 'event', 'scholarships' => 'scholarship',
            'dictionaries' => 'dictionary',
        ];
        return $types[$title] ?? '';
    }

    public function mapPosts($data): void
    {
        $data->map(function ($d) {
            $d->author = $d->user->name;
            $d->author_image = $d->user->userInfo['imagePath'] . $d->user->userInfo['preThumb'] . $d->user->image;
            $d->image = Posts::$uploadPath . $d->image;
            $d->post_updated = Helpers::toFormatDateString($d->updated_at, 'H:i A, j M Y');
            $d->isClosed = $d->status === 'close';

            if ($d->type === 'activity') {
                $d->formatted_start_date = Helpers::toFormatDateString($d->start_date, 'j M Y');
            }
            if ($d->type === 'event') {

                $d->formatted_start_date = Helpers::toFormatDateString($d->start_date, 'M d Y');
                $d->formatted_deadline = Helpers::toFormatDateString($d->deadline, 'M d Y');

                $d->during_time = Helpers::toFormatDateString($d->start_date, 'H:i A') . ' - ';
                $d->during_time .= Helpers::toFormatDateString($d->deadline, 'H:i A');
            }

            if ($d->type === 'scholarship') {
                $d->formatted_deadline = date('H:i A, M d Y', strtotime($d->deadline));
            }
            //remove relationship
            unset($d->user, $d->type);
            $d->setRelations([]);
            unset($d->user_id);
            //remove relationship
            return $d;
        });
    }

    public function mapPost($data): void
    {
        $data->next = $data->next();
        $data->previous = $data->previous();

        $data->author = $data->user->name . ' ' . $data->user->last_name;
        $data->author_image = $data->user->userInfo['imagePath'] . $data->user->userInfo['preThumb'] . $data->user->image;
        $data->image = Posts::$uploadPath . $data->image;
        $data->post_updated_ago = $data->updated_at->diffForHumans();
        $data->post_updated = Helpers::toFormatDateString($data->updated_at, 'H:i A, j M Y');
        $data->isClosed = $data->status === 'close';
        if ($data->type === 'activity') {
            $data->formatted_start_date = Helpers::toFormatDateString($data->start_date, 'j M Y');
            $data->formatted_start_date_ago = $data->start_date->diffForHumans();
        }
        if ($data->type === 'event') {
            $data->formatted_start_date = Helpers::toFormatDateString($data->start_date, 'M d Y');
            $data->formatted_deadline = Helpers::toFormatDateString($data->deadline, 'M d Y');
            $data->during_time = Helpers::toFormatDateString($data->start_date, 'H:i A') . ' - ';
            $data->during_time .= Helpers::toFormatDateString($data->deadline, 'H:i A');
        }
        if ($data->type === 'scholarship') {
            $data->formatted_deadline = date('H:i A, M d Y', strtotime($data->deadline));
        }
        //remove relationship
        unset($data->user, $data->type);
        $data->setRelations([]);
        unset($data->user_id);
        //remove relationship
    }
}
