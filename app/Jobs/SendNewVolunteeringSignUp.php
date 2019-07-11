<?php

namespace App\Jobs;

use App\Http\Controllers\Helpers\Helpers;
use App\Mail\UserActionsEmailNotify;
use App\Models\Site;
use App\Models\VolunteeringActivity;
use App\Models\VolunteeringActivityPosition;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendNewVolunteeringSignUp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $sign_up_activity;
    protected $user_sign_up;
    protected $settings;

    /**
     * Create a new job instance.
     *
     * @param $sign_up_activity
     * @param $user_sign_up
     */
    public function __construct($sign_up_activity, $user_sign_up)
    {
        $this->sign_up_activity = $sign_up_activity;
        $this->user_sign_up = $user_sign_up;
        $this->settings = $this->getSettings();
    }

    public function getSettings(): array
    {
        $settings = Site::select('id', 'key', 'value')
            ->whereNotIn('key', [])->get();
        $s = [];
        foreach ($settings as $setting) {
            $s[$setting->key] = $setting->value;
        }
        return $s;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $activity = VolunteeringActivity::find($this->sign_up_activity->volunteering_activity_id);
        $position = VolunteeringActivityPosition::find($this->sign_up_activity->volunteering_activity_position_id);
        if (isset($activity, $position)) {
            #map data
            $activity->start_date_formatted_number = Helpers::toFormatDateString($activity->start_date, 'd M Y');
            $activity->end_date_formatted_number = Helpers::toFormatDateString($activity->end_date, 'd M Y');
            $dateTime = $this->getDateTime($activity);
            #organize
            $organize = User::find($activity->user_id);
            #send to admin and organize
            $data['from'] = $this->settings['email'];
            $data['subject'] = 'New signing up volunteer activity | ' . $this->settings['site_name'];
            $data['user_name'] = 'Dear ' . $this->settings['site_name'];
            $data['content_text'] = "You are receiving this email because we received a new <b>Signing up volunteer activity</b>.<br><br>Details of the activity: <br>Activity name: $activity->name<br>Date & Time: $dateTime<br>Position: $position->title<br>Location: $activity->town, $activity->block_street<br>Building: $activity->building_name, $activity->building_unit_number<br>";

            $link = route('get.home.volunteer.activity', $activity->id);
            $data['bottom_text'] = 'If you did not request to check it now, no further action is required.';
            $data['button_text'] = 'See the volunteering activity';
            $data['button_link'] = $link;
            $data['footer_text'] = 'If you’re having trouble clicking the button, copy and paste the URL below into your web browser: ' . $link;
            Mail::to($this->settings['email'])->send(new UserActionsEmailNotify($data));
            $data['user_name'] = 'Dear ' . $organize->name;
            Mail::to($organize->email)->send(new UserActionsEmailNotify($data));
            #send to volunteer
            $contact_title = ucfirst($activity->contact_title);
            $data['from'] = $this->settings['email'];
            $data['subject'] = 'Volunteer Activity Signup -  ' . $activity->name . '  | ' . $this->settings['site_name'];
            $data['user_name'] = 'Dear ' . $this->user_sign_up->name;
            $data['content_text'] = "Thank you for signing up to volunteer for activity {$activity->name}.<br>Details of the activity: <br>Date & Time: $dateTime<br>Position: $position->title<br>Location: $activity->town, $activity->block_street<br>Building: $activity->building_name, $activity->building_unit_number<br><br>If you need more details on this activity, please visit the activity page or contact:<br>{$contact_title} {$activity->contact_name}<br>{$activity->contact_designation}<br>{$activity->contact_phone_number}<br>{$activity->contact_email}<br><br>See you on the From {$activity->start_date_formatted_number} to
            {$activity->end_date_formatted_number}";

            $link = route('get.volunteer.index', $activity->id) . '?active_page=activities';
            $data['bottom_text'] = 'If you did not request to check it now, no further action is required.';
            $data['button_text'] = 'My volunteering activities';
            $data['button_link'] = $link;
            $data['footer_text'] = 'If you’re having trouble clicking the button, copy and paste the URL below into your web browser: ' . $link;
            Mail::to($this->user_sign_up->email)->send(new UserActionsEmailNotify($data));
        }
    }

    public function getDateTime($activity)
    {
        $days_of_week = [];
        if ($activity->weekday === 'yes') {
            $days_of_week[] = 'weekday';
        }
        if ($activity->weekend === 'yes') {
            $days_of_week[] = 'weekend';
        }
        $frequency = $this->getFrequency()[$activity->frequency];
        $hour_per_session = "$activity->duration hours per session";
        $days_of_week = implode(' or ', $days_of_week);

        return "$activity->start_date_formatted_number to
            $activity->end_date_formatted_number $frequency $hour_per_session on $days_of_week";
    }

    public function getFrequency()
    {
        return [
            '1_DAY_PER_WEEK' => 'One day per week',
            '2_3_DAYS_PER_WEEK' => '2-3 days per week',
            'FORTNIGHTLY' => 'Fortnightly',
            'MONTHLY' => 'Monthly',
            'QUARTERLY' => 'Quarterly',
            'FLEXIBLE' => 'Flexible',
            'FULL_TIME' => 'Full Time'
        ];
    }
}
