<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 2/11/2019
 * Time: 2:38 PM
 */

namespace App\Responses;


use App\Http\Controllers\Helpers\Helpers;
use App\Models\NewsLetter;
use Illuminate\Contracts\Support\Responsable;

class SaveNewsLetterResponse implements Responsable
{

    protected $actionType = 'get';

    public function __construct($actionType)
    {
        $this->actionType = $actionType;
    }

    /**
     * Create an HTTP response that represents the object.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function toResponse($request)
    {
        if (Helpers::isAjax($request)) {
            if ($this->actionType === 'save') {
                $newsLetter = new NewsLetter();
                $newsLetter->email = $request->get('email');
                $newsLetter->save();
                return response()->json(['success' => true, 'data' => $newsLetter, 'msg' => 'Your information was saved!.']);
            }
            return response()->json(['success' => false, 'data' => null]);
        }
    }

}
