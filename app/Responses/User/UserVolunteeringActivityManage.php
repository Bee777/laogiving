<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 2/25/2019
 * Time: 11:03 PM
 */

namespace App\Responses\User;

use App\Http\Controllers\Helpers\Helpers;
use App\Models\Cause;
use App\Models\CauseDetail;
use App\Models\Media;
use App\Models\Skill;
use App\Models\Suitable;
use App\User;
use Illuminate\Contracts\Support\Responsable;

class UserVolunteeringActivityManage implements Responsable
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
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        $data = [];
        if (Helpers::isAjax($request)) {
            $user = $request->user();
            if ($user->isUser('volunteer')) {
                if ($this->actionType === 'insert') {






                    return response()->json(['success' => true, 'data' => $data]);
                } else if ($this->actionType === 'update') {

                    return response()->json(['success' => true, 'data' => $data]);

                } else if ($this->actionType === 'delete') {

                    return response()->json(['success' => true, 'data' => $data]);
                }
            }
            return response()->json(['success' => false, 'data' => $data]);
        }
    }
}
