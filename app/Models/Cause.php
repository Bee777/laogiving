<?php

namespace App\Models;

use App\Http\Controllers\Helpers\Helpers;
use DOMDocument;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Cause extends Model
{
    public static function getCauses($limit)
    {
        $mLimit = Helpers::isNumber($limit) ? $limit : 3;
        if ($limit === 'all') {
            $causes = self::orderBy('id', 'asc')->get();
        } else {
            $causes = self::limit($mLimit)->orderBy('id', 'asc')->get();
        }
        $causes->map(function ($cause) {
            $key_cache = 'cause_svg_cache_';
            if (!Cache::has($key_cache . $cause->id)) {
                $filePath = 'assets/images/icon/causes/' . $cause->icon;
                if (Helpers::fileExists($filePath)) {
                    $svg = new DOMDocument();
                    // Load SVG file from public folder
                    $svg->load(public_path($filePath));
                    // Add CSS class (you can omit this line)
                    $svg->documentElement->setAttribute('class', 'svg-causes');
                    // Get XML without version element
                    $icon = $svg->saveXML($svg->documentElement);
                    Cache::put($key_cache . $cause->id, $icon, now()->addSeconds(10));
                    $cause->icon = $icon;
                } else {
                    $icon = self::defaultIcon();
                    Cache::put($key_cache . $cause->id, $icon, now()->addSeconds(4));
                    $cause->icon = $icon;
                }
            } else {
                $cause->icon = Cache::get($key_cache . $cause->id);
            }
            $cause->small_icon = url('/assets/images/icon/causes') . '/' . $cause->small_icon;
            $cause->background_image = url('/assets/images/icon/causes') . '/' . $cause->background_image;
            return $cause;
        });
        return $causes;
    }

    public static function defaultIcon(): string
    {
        return '<svg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"><title>
                ic-animal-welfare-hp</title>
                <g fill="none" fill-rule="evenodd">
                    <path
                        d="M34.513 30.25c.694 1.76.645 3.58-.14 5.262-.896 1.927-2.897 2.988-5.634 2.988h-.002c-2.785 0-5.768-1.056-7.36-2.037-1.602-.985-2.298-1.16-2.47-1.19-.106.013-.215.013-.324 0-.147.026-.84.192-2.46 1.19-1.594.98-4.578 2.037-7.362 2.037-2.738 0-4.74-1.06-5.636-2.988-.785-1.683-.832-3.503-.14-5.262.932-2.36 2.98-4.043 4.6-4.665 1.393-.536 2.065-2.022 3.453-5.333.238-.57.494-1.18.775-1.832 1.97-4.565 5.602-4.92 6.667-4.92.108 0 .198.003.268.007.07-.004.16-.007.267-.007 1.066 0 4.696.355 6.667 4.92.28.652.537 1.263.777 1.833 1.39 3.31 2.06 4.796 3.455 5.332 1.618.622 3.667 2.306 4.598 4.665zM6.535 23.354c2.623-.657 4.07-3.37 3.223-6.045-.71-2.244-2.807-3.81-5.104-3.81-.402 0-.802.05-1.19.146-2.622.657-4.068 3.37-3.222 6.045.71 2.244 2.808 3.81 5.104 3.81.402 0 .802-.05 1.19-.146zM12.82 13.5c.24 0 .484-.022.722-.065 1.35-.247 2.53-1.193 3.24-2.594.658-1.303.873-2.895.606-4.483C16.865 3.253 14.675 1 12.18 1c-.24 0-.484.022-.722.066-1.35.246-2.53 1.192-3.24 2.594-.658 1.303-.873 2.896-.606 4.483.522 3.104 2.712 5.357 5.207 5.357zm26.688 2.518c-.59-1.18-1.673-2.046-2.975-2.372-.387-.097-.787-.146-1.19-.146-2.294 0-4.393 1.566-5.1 3.808-.847 2.677.6 5.39 3.22 6.046.388.097.788.146 1.19.146 2.295 0 4.394-1.566 5.103-3.808.396-1.254.308-2.56-.248-3.674zm-15.55-2.583c.238.043.48.065.723.065 2.496 0 4.687-2.253 5.21-5.357.574-3.41-1.152-6.585-3.848-7.078C25.804 1.022 25.56 1 25.32 1c-2.496 0-4.687 2.253-5.21 5.357-.574 3.41 1.152 6.585 3.848 7.078z"
                        class="fill-color" fill="#666"></path>
                    <path d="M0 0h40v40H0z"></path>
                </g>
            </svg>';
    }
}
