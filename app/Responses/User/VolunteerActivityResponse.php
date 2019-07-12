<?php
/**
 * Created by PhpStorm.
 * User: BeeTimberlake
 * Date: 2/25/2019
 * Time: 11:03 PM
 */

namespace App\Responses\User;

use App\Http\Controllers\Helpers\Helpers;
use App\Models\VolunteeringActivity;
use App\User;
use Illuminate\Contracts\Support\Responsable;
use File;

class VolunteerActivityResponse implements Responsable
{
    protected $actionType = 'get';
    protected $options = [];

    public function __construct($actionType, $options = [])
    {
        $this->options = $options;
        $this->actionType = $actionType;
    }

//    GET
    public function get($request)
    {
        $fields = [
            'name',
            'description',
            'volunteer_type',
            'duration',
            'start_date',
            'end_date',
            'deadline_sign_ups_date',
            'points_to_note',
            'other_response_required',
            'town',
            'block_street',
            'building_name',
            'building_unit_number',
            'contact_title',
            'contact_name',
            'contact_designation',
            'contact_phone_number',
            'contact_email',
            'created_at', 'updated_at'];
        $request->request->add(['fields' => $fields]);
        $text = $this->options['text'];
        $paginateLimit = $this->options['limit'];
        $data = VolunteeringActivity::select(array_merge($fields, [
            'id',
            'frequency',
            'weekday',
            'weekend',
            'volunteer_gender',
            'volunteer_contact_phone_number',
            'volunteer_signups_confirm',
            'user_id',
            'status',
        ]));
        $data->where(function ($query) use ($request, $text) {
            foreach ($request->fields as $k => $f) {
                if ($f === 'start_date' || $f === 'end_date' ||
                    $f === 'deadline_sign_ups_date' || $f === 'created_at' || $f === 'updated_at') {
                    if (Helpers::isEngText($text)) {
                        $query->orWhere($f, 'LIKE', "%{$text}%");
                    } else {
                        continue;
                    }
                }
                $query->orWhere($f, 'LIKE', "%{$text}%");
            }
        });

        $data = $data->orderBy('id', 'desc')->paginate($paginateLimit);
        $data->map(function ($activity) {
            $activity->statusColor = $activity->status === 'live' ? '#00bfa5' : ($activity->status === 'disabled' ? '#d50000' :
                $activity->status === 'draft' ? '#04a3ec' : '#feb632');
            $user = User::find($activity->user_id);
            $activity->organize_name = $user ? $user->name : 'No data';
        });

        return $data;
    }
// END   GET

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {

    }
}
