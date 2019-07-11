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
use App\Models\VolunteeringActivity;
use App\Traits\DefaultData;
use App\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\DB;

class PostsResponse implements Responsable
{
    use DefaultData;

    protected $options = [];
    protected $type = '';

    public function __construct($options, $type)
    {
        $this->options = $options;
        $this->type = $type;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response | mixed
     */
    public function toResponse($request)
    {
        $post_type_name = ucfirst($this->type);
        if (Helpers::isAjax($request)) {
            return $this->postsPaginator($request);
        }

        $type = $this->getPostsType($this->type);
        if (empty($type)) {
            return redirect('/');
        }
        return view("{$this->options['rootView']}.posts",
            array_merge(['post_type_name' => $post_type_name], $this->getDefaultData($request)));
    }

    public function postsPaginator($request): array
    {
        $type = $this->getPostsType($this->type);
        $paginateLimit = ($request->exists('limit') && !empty($request->get('limit'))) ? $request->get('limit') : 6;
        $paginateLimit = Helpers::isNumber($paginateLimit) ? $paginateLimit : 6;
        $text = $request->get('q');
        //@for volunteer activities only
        if ($type === 'activity') {
            return $this->getVolunteerings($request, $text, $paginateLimit);
        }
        //@for volunteer activities only


        $fields = ['id', 'title', 'type', 'image', 'description', 'status', 'place', 'hosted_by', 'start_date', 'deadline', 'updated_at', 'user_id',];
        $request->request->add(['fields' => $fields]);
        $data = Posts::select($fields)->where('type', $type)->whereIn('status', ['open', 'close']);
        /**@Query */
        $data->where(function ($query) use ($request, $text) {
            foreach ($request->fields as $k => $f) {
                if ($f === 'start_date' || $f === 'deadline' || $f === 'updated_at') {
                    if (Helpers::isEngText($text)) {
                        $query->orWhere($f, 'LIKE', "%{$text}%");
                    } else {
                        continue;
                    }
                }
                $query->orWhere($f, 'LIKE', "%{$text}%");
            }
        });
        $data = $data->orderBy('status', 'desc')->paginate($paginateLimit);
        $this->mapPosts($data);
        $data->appends(['limit' => $paginateLimit, 'q' => $text]);
        /**@Query */
        /**@mostViewsPosts */
        $mostViewsPosts = Posts::select($fields)->where('type', $type)->where('status', 'open')->limit(5)->orderBy('view', 'desc')->get();
        $this->mapPosts($mostViewsPosts);
        /**@mostViewsPosts */
        /**@comingEvents */
        $rawQuery = 'datediff(now(), start_date)';
        $comingEvents = Posts::select($fields)->where('type', 'event')->where('status', 'open')->limit(4)
            ->where(DB::raw($rawQuery), '<=', 0)
            ->orderBy(DB::raw($rawQuery), 'desc')->get();
        $this->mapPosts($comingEvents);
        /**@comingEvents */
        return ['posts' => $data, 'mostViews' => $mostViewsPosts, 'comingEvents' => $comingEvents];
    }

    public function getPostsType($title)
    {
        $types = [
            'activities' => 'activity', 'news' => 'news',
            'events' => 'event', 'scholarships' => 'scholarship',
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
                $d->formatted_start_date = Helpers::toFormatDateString($d->updated_at, 'H:i A, j M Y');
            }
            if ($d->type === 'event') {
                $d->during_time = Helpers::toFormatDateString($d->start_date, 'H:i A') . ' - ';
                $d->during_time .= Helpers::toFormatDateString($d->deadline, 'H:i A');
                $d->formatted_start_date = Helpers::toFormatDateString($d->start_date, 'M d Y');
                $d->formatted_deadline = Helpers::toFormatDateString($d->deadline, 'M d Y');
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

    public function getVolunteerings($request, $text, $paginateLimit)
    {
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

        $request->request->add(['fields' => $fields]);

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
            ->where('users.status', 'approved');

        $dataFilter = [];

        $causes = array_filter(explode(',', $request->causes));
        $openings = array_filter(explode(',', $request->openings));
        $skills = array_filter(explode(',', $request->skills));
        $suitables = array_filter(explode(',', $request->suitables));
        $weekday_or_weekend = array_filter(explode(',', $request->weekday_or_weekend));
        $commitment_duration = array_filter(explode(',', $request->commitment_duration));
        $frequency = array_filter(explode(',', $request->frequency));
        $organizations = null;
        $total_count_organization = 0;
        #organizations
        if ($request->is_filtering !== null) {
            $organize_fields = ['users.id', 'users.image', 'users.status', 'users.name', 'users.email', 'users.created_at', 'users.updated_at',
                'organize_profiles.about', 'organize_profiles.display_name'];
            $request->request->add(['organize_fields' => $organize_fields]);

            $organizations = User::select($organize_fields)->join('user_types', 'user_types.user_id', 'users.id')
                ->join('organize_profiles', 'organize_profiles.user_id', 'users.id')
                ->where('organize_profiles.visibility', 'visible')
                ->where('user_types.type_user_id', $this->getTypeUserId('organize'))
                ->where('users.status', 'approved');
            #filter by searching
            $organizations->where(function ($query) use ($request, $text) {
                foreach ($request->organize_fields as $k => $f) {
                    if ($f === 'users.created_at' || $f === 'users.updated_at') {
                        if (Helpers::isEngText($text)) {
                            $query->orWhere($f, 'LIKE', "%{$text}%");
                        } else {
                            continue;
                        }
                    }
                    if ($f === 'users.name as organize') {
                        $query->orWhere('users.name', 'LIKE', "%{$text}%");
                    } else {
                        $query->orWhere($f, 'LIKE', "%{$text}%");
                    }
                }
            });
            #filter by causes
            if (count($causes) > 0) {
                $dataFilter['causes_organize'] = DB::table('cause_details')->select('related_id')
                    ->where('type', 'user')
                    ->whereIn('cause_id', $causes)
                    ->groupBy('related_id')
                    ->havingRaw('count(DISTINCT cause_id) = ' . count($causes))->pluck('related_id')->toArray();
                $organizations->whereIn('users.id', $dataFilter['causes_organize']);
            }

            #all count
            $total_organization_data = clone $organizations;
            $total_count_organization = $total_organization_data->get()->count();
            #set data
            $organizations = $organizations->orderBy('id', 'desc')->paginate($paginateLimit);
            #map data
            $organizations->map(function ($d) {
                $d->image = "/assets/images/user_profiles/{$d->image}";
                $d->volunteering = VolunteeringActivity::where('user_id', $d->id)->whereIn('status', ['live', 'closed'])->get()->count();
                return $d;
            });
        }
        #end organizations
        #filter by openings
        if (count($openings) > 0) {
            foreach ($openings as $opening) {
                $btw = explode('-', $opening);
                $dataFilter['positions_vacancies'] = DB::table('volunteering_activities')
                    ->select('volunteering_activities.id')
                    ->join('volunteering_activity_positions', 'volunteering_activity_positions.volunteering_activity_id', 'volunteering_activities.id')
                    ->orWhereBetween('volunteering_activity_positions.vacancies', $btw)
                    ->groupBy('volunteering_activities.id')
                    ->pluck('volunteering_activities.id')->toArray();
            }
            $data->whereIn('volunteering_activities.id', $dataFilter['positions_vacancies']);
        }

        #filter by date all date tomorrow
        $date = $request->date;
        if ($date === 'tomorrow') {
            $data->where('volunteering_activities.start_date', '=', DB::raw('CURDATE() + INTERVAL 1 DAY'));
        }
        #filter by causes
        if (count($causes) > 0) {
            $dataFilter['causes'] = DB::table('cause_details')->select('related_id')
                ->where('type', 'activity')
                ->whereIn('cause_id', $causes)
                ->groupBy('related_id')
                ->havingRaw('count(DISTINCT cause_id) = ' . count($causes))->pluck('related_id')->toArray();

            $data->whereIn('volunteering_activities.id', $dataFilter['causes']);
        }
        #filter by skills positions

        if (count($skills) > 0) {
            $dataFilter['skills'] = DB::table('volunteering_activities')->select('volunteering_activities.id')
                ->join('volunteering_activity_positions', 'volunteering_activity_positions.volunteering_activity_id', 'volunteering_activities.id')
                ->join('volunteering_activity_position_skills', 'volunteering_activity_position_skills.volunteering_activity_position_id', 'volunteering_activity_positions.id')
                ->whereIn('volunteering_activity_position_skills.skill_id', $skills)
                ->groupBy('volunteering_activities.id')
                ->havingRaw('count(DISTINCT volunteering_activity_position_skills.skill_id) = ' . count($skills))->pluck('volunteering_activities.id')->toArray();

            $data->whereIn('volunteering_activities.id', $dataFilter['skills']);
        }

        #filter by suitables positions
        if (count($suitables) > 0) {
            $dataFilter['suitables'] = DB::table('volunteering_activities')->select('volunteering_activities.id')
                ->join('volunteering_activity_positions', 'volunteering_activity_positions.volunteering_activity_id', 'volunteering_activities.id')
                ->join('volunteering_activity_position_suitables', 'volunteering_activity_position_suitables.volunteering_activity_position_id', 'volunteering_activity_positions.id')
                ->whereIn('volunteering_activity_position_suitables.suitable_id', $suitables)
                ->groupBy('volunteering_activities.id')
                ->havingRaw('count(DISTINCT volunteering_activity_position_suitables.suitable_id) = ' . count($suitables))->pluck('volunteering_activities.id')->toArray();

            $data->whereIn('volunteering_activities.id', $dataFilter['suitables']);
        }

        #filter by searching
        $data->where(function ($query) use ($request, $text) {
            foreach ($request->fields as $k => $f) {
                if ($f === 'volunteering_activities.start_date' || $f === 'volunteering_activities.end_date' ||
                    $f === 'volunteering_activities.deadline_sign_ups_date' || $f === 'volunteering_activities.created_at' ||
                    $f === 'volunteering_activities.updated_at') {
                    if (Helpers::isEngText($text)) {
                        $query->orWhere($f, 'LIKE', "%{$text}%");
                    } else {
                        continue;
                    }
                }
                if ($f === 'users.name as organize') {
                    $query->orWhere('users.name', 'LIKE', "%{$text}%");
                } else {
                    $query->orWhere($f, 'LIKE', "%{$text}%");
                }
            }
        });

        #filter by weekday or weekend
        if (count($weekday_or_weekend) > 0) {
            $days_of_week = ['weekday', 'weekend'];
            $data->where(function ($query) use ($days_of_week, $weekday_or_weekend) {
                foreach ($weekday_or_weekend as $day_of_week) {
                    $low = strtolower($day_of_week);
                    if (in_array($low, $days_of_week, true)) {
                        $query->orWhere('volunteering_activities.' . $low, 'yes');
                    }
                }
            });
        }
        #filter by commitment_duration
        if (count($commitment_duration) > 0) {
            $data->where(function ($query) use ($commitment_duration) {
                foreach ($commitment_duration as $date_duration) {
                    $btw = explode('-', $date_duration);
                    $query->orWhereBetween(DB::raw('TIMESTAMPDIFF(MONTH, start_date, end_date)'), $btw);
                }
            });
        }
        #filter by  frequency
        if (count($frequency) > 0) {
            $data->where(function ($query) use ($frequency) {
                foreach ($frequency as $fr) {
                    $query->orWhere('volunteering_activities.frequency', $fr);
                }
            });
        }
        #grouping
        $data = $data->groupBy('volunteering_activities.id');
        #all count
        $total_data = clone $data;
        $total_count = $total_data->get()->count();
        #set data
        $data = $data->orderBy('id', 'desc')->paginate($paginateLimit);
        #map data
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
        return ['posts' => $data, 'total_count' => $total_count, 'mostViews' => [], 'comingEvents' => [], 'organizations' => $organizations, 'total_count_organization' => $total_count_organization];
    }
}
