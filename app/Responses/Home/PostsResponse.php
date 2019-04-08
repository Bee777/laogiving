<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 3/3/2019
 * Time: 11:33 AM
 */

namespace App\Responses\Home;


use App\Banner;
use App\Dictionary;
use App\Http\Controllers\Helpers\Helpers;
use App\Posts;
use App\Traits\DefaultData;
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

        //@for dictionaries only
        if ($type === 'dictionary') {
            $fields = ['id', 'lao', 'japanese', 'description', 'updated_at'];
            $request->request->add(['fields' => $fields]);
            $data = Dictionary::select($fields);
            /**@Query */
            $data->where(function ($query) use ($request, $text) {
                foreach ($request->fields as $k => $f) {
                    if ($f === 'updated_at') {
                        if (Helpers::isEngText($text)) {
                            $query->orWhere($f, 'LIKE', "%{$text}%");
                        } else {
                            continue;
                        }
                    }
                    $query->orWhere($f, 'LIKE', "%{$text}%");
                }
            });
            /**@Query */
            $data = $data->orderBy('id', 'desc')->paginate($paginateLimit);
            $data->appends(['limit' => $paginateLimit, 'q' => $text]);
            return ['posts' => $data, 'mostViews' => [], 'comingEvents' => []];
        }
        //@for dictionaries only

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
}
