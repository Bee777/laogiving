<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 2/11/2019
 * Time: 2:38 PM
 */

namespace App\Responses\User;

use App\Http\Controllers\Helpers\Helpers;
use App\Models\Cause;
use Illuminate\Contracts\Support\Responsable;
use Image;

class CausesResponse implements Responsable
{

    protected $actionType = 'get';
    public static $uploadPath = '/assets/images/icon/causes/';
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
        $data = Cause::select(array_merge($fields, ['icon', 'background_image']));
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
        $data->map(function ($d) {
            $d->filename = $d->icon;
            $d->icon = self::$uploadPath . $d->icon;
            $d->filename_bg = $d->background_image;
            $d->background_image = self::$uploadPath . $d->background_image;
            return $d;
        });
        return $data;
    }

    public function toResponse($request)
    {
        $data = [];
        if (Helpers::isAjax($request)) {
            if ($this->actionType === 'insert') {
                #icon
                $file = $request->file('icon');
                $fileExt = strtolower($file->getClientOriginalExtension());
                $imgOriginalName = Helpers::subFileName($file->getClientOriginalName()) . md5('^');
                $img_filename = $imgOriginalName . md5(uniqid('icon-causes', true)) . '_icon.' . $fileExt;
                if ($fileExt === 'gif' || $fileExt === 'svg') {
                    $location = public_path(self::$uploadPath);
                    $file->move($location, $img_filename);
                } else {
                    $img = Image::make($file);
                    $location = public_path(self::$uploadPath . $img_filename);
                    $img->save($location)->destroy();
                }
                #bg image
                $file_bg = $request->file('background_image');
                $file_bgExt = strtolower($file_bg->getClientOriginalExtension());
                $imgBgOriginalName = Helpers::subFileName($file_bg->getClientOriginalName()) . md5('^');
                $img_bg_filename = $imgBgOriginalName . md5(uniqid('background_image-causes', true)) . '_background_image.' . $file_bgExt;
                if ($file_bgExt === 'gif' || $file_bgExt === 'svg') {
                    $location = public_path(self::$uploadPath);
                    $file_bg->move($location, $img_bg_filename);
                } else {
                    $img = Image::make($file_bg);
                    $location = public_path(self::$uploadPath . $img_bg_filename);
                    $img->save($location)->destroy();
                }

                $info = new Cause();
                $info->name = $request->get('name');
                $info->icon = $img_filename;
                $info->background_image = $img_bg_filename;
                $info->save();
                $data = $info;
            } else if ($this->actionType === 'update') {
                $info = Cause::find($request->id);
                if (isset($info)) {

                    if ($request->hasFile('icon')) {
                        $file = $request->file('icon');
                        $fileExt = strtolower($file->getClientOriginalExtension());
                        $imgOriginalName = Helpers::subFileName($file->getClientOriginalName()) . md5('^');
                        $img_filename = $imgOriginalName . md5(uniqid('icon-causes', true)) . '_icon.' . $fileExt;
                        if ($fileExt === 'gif' || $fileExt === 'svg') {
                            $location = public_path(self::$uploadPath);
                            $file->move($location, $img_filename);
                        } else {
                            $img = Image::make($file);
                            $location = public_path(self::$uploadPath . $img_filename);
                            $img->save($location)->destroy();
                        }
                        Helpers::removeFile(self::$uploadPath . $info->icon);
                    }

                    if ($request->hasFile('background_image')) {
                        $file_bg = $request->file('background_image');
                        $file_bgExt = strtolower($file_bg->getClientOriginalExtension());
                        $imgBgOriginalName = Helpers::subFileName($file_bg->getClientOriginalName()) . md5('^');
                        $img_bg_filename = $imgBgOriginalName . md5(uniqid('background_image-causes', true)) . '_background_image.' . $file_bgExt;
                        if ($file_bgExt === 'gif' || $file_bgExt === 'svg') {
                            $location = public_path(self::$uploadPath);
                            $file_bg->move($location, $img_bg_filename);
                        } else {
                            $img = Image::make($file_bg);
                            $location = public_path(self::$uploadPath . $img_bg_filename);
                            $img->save($location)->destroy();
                        }
                        Helpers::removeFile(self::$uploadPath . $info->background_image);
                    }

                    $info->name = $request->get('name');
                    $info->icon = $img_filename ?? $info->icon;
                    $info->background_image = $img_bg_filename ?? $info->background_image;
                    $info->save();
                    $data = $info;
                }
            } else if ($this->actionType === 'delete') {
                $info = Cause::find($request->id);
                if (isset($info)) {
                    Helpers::removeFile(self::$uploadPath . $info->icon);
                    Helpers::removeFile(self::$uploadPath . $info->background_image);
                    $info->delete();
                    $data = $info;
                }
            }
            return response()->json(['success' => true, 'data' => $data]);
        }
    }
}
