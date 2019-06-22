<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 2/11/2019
 * Time: 2:38 PM
 */

namespace App\Responses\User;

use App\Http\Controllers\Helpers\Helpers;
use App\Models\Skill;
use Illuminate\Contracts\Support\Responsable;

class SkillsResponse implements Responsable
{

    protected $actionType = 'get';
    protected $options = [];

    public function __construct($actionType, $options = [])
    {
        $this->options = $options;
        $this->actionType = $actionType;
    }

    /**
     * Create an HTTP response that represents the object.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function get($request)
    {
        $fields = ['id', 'name', 'created_at', 'updated_at'];
        $request->request->add(['fields' => $fields]);
        $text = $this->options['text'];
        $paginateLimit = $this->options['limit'];
        $data = Skill::select($fields);
        $data->where(function ($query) use ($request, $text) {
            foreach ($request->fields as $k => $f) {
                if ($f === 'created_at' || $f === 'updated_at') {
                    if (Helpers::isEngText($text)) {
                        $query->orWhere($f, 'LIKE', "%{$text}%");
                    } else {
                        continue;
                    }
                }
                $query->orWhere($f, 'LIKE', "%{$text}%");
            }
        });
        $data = $data->orderBy('created_at', 'desc')->paginate($paginateLimit);
        return $data;
    }

    public function toResponse($request)
    {
        $data = [];
        if (Helpers::isAjax($request)) {
            if ($this->actionType === 'insert') {
                $info = new Skill();
                $info->name = $request->get('name');
                $info->save();
                $data = $info;
            } else if ($this->actionType === 'update') {
                $info = Skill::find($request->id);
                if (isset($info)) {
                    $info->name = $request->get('name');
                    $info->save();
                    $data = $info;
                }
            } else if ($this->actionType === 'delete') {
                $info = Skill::find($request->id);
                if (isset($info)) {
                    $info->delete();
                    $data = $info;
                }
            }
            return response()->json(['success' => true, 'data' => $data]);
        }
    }
}
