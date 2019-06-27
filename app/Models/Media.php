<?php

namespace App\Models;

use App\Http\Controllers\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Validator;

class Media extends Model
{
    public static $uploadPath = '/assets/images/media/images/';

    public static function updateUser($media_id, $user_id, $media_type, string $url): void
    {
        self::updateData($media_id, $user_id, 'user', $media_type, $url);
    }

    public static function saveUser($user_id, $media_type, string $url): void
    {
        self::saveData($user_id, 'user', $media_type, $url);
    }

    public static function updateActivity($media_id, $activity_id, $media_type, string $url): void
    {
        self::updateData($media_id, $activity_id, 'activity', $media_type, $url);
    }

    public static function saveActivity($activity_id, $media_type, string $url): void
    {
        self::saveData($activity_id, 'activity', $media_type, $url);
    }

    public static function single(string $related_type, string $media_type, $id, $map = true)
    {
        $data = self::where('related_type', $related_type)->where('media_type', $media_type)->where('related_id', $id)->first();
        if (isset($data)) {
            if ($map) {
                $func = 'map' . ucfirst($data->media_type);
                self::$func($data);
            }
            return $data;
        }
        return null;
    }

    public static function list(string $related_type, string $media_type, $id, $limit = 0, $map = true)
    {
        if ($limit <= 0) {
            $data = self::where('related_type', $related_type)->where('media_type', $media_type)->where('related_id', $id)->get();
            if ($map) {
                $data->map(function ($item) {
                    $func = 'map' . ucfirst($item->media_type);
                    self::$func($item);
                    return $item;
                });
            }
            return $data;
        }
        $data = self::where('related_type', $related_type)->where('media_type', $media_type)->where('related_id', $id)->limit($limit)->get();
        if ($map) {
            $data->map(function ($item) {
                $func = 'map' . ucfirst($item->media_type);
                self::$func($item);
                return $item;
            });
        }
        return $data;
    }

    public static function mapYoutube($media)
    {
        $media->validated = '';
    }

    public static function mapImage($media)
    {
        $media->image_base64 = url(self::$uploadPath . $media->url);
        $media->image = null;
        $media->validated = '';
        $media->removable = false;
    }

    protected static function saveData($related_id, $related_type, $media_type, string $url)
    {
        $mediaModel = new self();
        $mediaModel->url = $url;
        $mediaModel->media_type = $media_type;
        $mediaModel->related_type = $related_type;
        $mediaModel->related_id = $related_id;
        $mediaModel->save();
        return $mediaModel;
    }

    protected static function updateData($media_id, $related_id, $related_type, $media_type, string $url)
    {
        $mediaModel = self::find($media_id);
        if (isset($mediaModel)) {
            $mediaModel->url = $url;
            $mediaModel->media_type = $media_type;
            $mediaModel->related_type = $related_type;
            $mediaModel->related_id = $related_id;
            $mediaModel->save();
            return $mediaModel;
        }
        return false;
    }

    public static function deleteMultiData(array $cleareds = [])
    {
        foreach ($cleareds as $cleared) {
            $media = self::find($cleared);
            if (isset($media)) {
                Helpers::removeFile(self::$uploadPath . $media->url);
                $media->delete();
            }
        }
    }

    public static function saveMultiData($related_id, $related_type, $media_type, $media): void
    {
        $mediasModel = self::list($related_type, $media_type, $related_id, 0, false);
        if (count($mediasModel) > 0) {
            $mediasCount = count($media);
            $diff = count($mediasModel) - $mediasCount;
            if ($diff >= 0) {
                foreach ($media as $key => $item) {
                    $mediaModel = $mediasModel[$key];
                    $rules = array('img' => 'required|mimes:png,jpg,jpeg,svg,gif|max:3000');
                    $validator = Validator::make(array('img' => $item), $rules);
                    if ($validator->passes()) {
                        Helpers::removeFile(self::$uploadPath . $mediaModel->url);
                        $url = Helpers::upLoadImage($item, self::$uploadPath, "_{$related_type}_{$media_type}", true);
                        self::updateData($mediaModel->id, $related_id, $related_type, $media_type, $url);
                    }
                }
                for ($i = 0; $i < $diff; $i++) {
                    if (isset($mediasModel[$mediasCount + $i])) {
                        $mediaModel = $mediasModel[$mediasCount + $i];
                        Helpers::removeFile(self::$uploadPath . $mediaModel->url);
                        $mediaModel->delete();
                    } else {
                        Log::info("#media-detail-delete# diff: $diff, i: $i, related type: $related_type media type: $media_type, id: $related_id");
                    }
                }
            } else {
                foreach ($media as $key => $item) {
                    $rules = array('img' => 'required|mimes:png,jpg,jpeg,svg,gif|max:3000');
                    $validator = Validator::make(array('img' => $item), $rules);
                    if ($validator->passes()) {
                        if (isset($mediasModel[$key])) {
                            $mediaModel = $mediasModel[$key];
                            Helpers::removeFile(self::$uploadPath . $mediaModel->url);
                            $url = Helpers::upLoadImage($item, self::$uploadPath, "_{$related_type}_{$media_type}", true);
                            self::updateData($mediaModel->id, $related_id, $related_type, $media_type, $url);
                        } else {
                            $url = Helpers::upLoadImage($item, self::$uploadPath, "_{$related_type}_{$media_type}", true);
                            self::saveData($related_id, $related_type, $media_type, $url);
                        }
                    }
                }
            }
        } else {
            foreach ($media as $item) {
                $rules = array('img' => 'required|mimes:png,jpg,jpeg,svg,gif|max:3000');
                $validator = Validator::make(array('img' => $item), $rules);
                if ($validator->passes()) {
                    $url = Helpers::upLoadImage($item, self::$uploadPath, "_{$related_type}_{$media_type}", true);
                    self::saveData($related_id, $related_type, $media_type, $url);
                }
            }
        }

    }
}
