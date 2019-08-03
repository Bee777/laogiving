<?php

namespace App\Jobs;

use App\Mail\UserActionsEmailNotify;
use App\Models\OrganizeProfile;
use App\Models\Site;
use App\Models\VolunteeringActivity;
use App\Traits\UserRoleTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendReportAbuse implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, UserRoleTrait;
    protected $data;
    protected $settings;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
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
        if (!isset($this->data['data'])) {
            return;
        }
        $type = $this->data['data']['type'] ?? 'profile';

        if ($type === 'profile') {
            $user_id = $this->data['data']['user_id'] ?? 0;
            $profile = OrganizeProfile::where('user_id', $user_id)->first();

            $data['from'] = $this->settings['email'];
            $data['subject'] = 'New Report Abuse Information | ' . $this->settings['site_name'];
            $data['user_name'] = 'Dear ' . $this->settings['site_name'];
            $data['content_text'] = "You are receiving this email because we received a new report abuse <b>Organize Profile</b> information on your site.<br> Email: {$this->data['email']}<br>Reason: {$this->data['reason']}.";
            $link = route('get.home.organize.profile', $user_id);
            $data['bottom_text'] = 'If you did not request to check it now, no further action is required.';
            $data['button_text'] = isset($profile) ? 'See the profile.' : 'No profile for now.';
            $data['button_link'] = $link;
            $data['footer_text'] = 'If you’re having trouble clicking the button, copy and paste the URL below into your web browser: ' . $link;
            Mail::to($this->settings['email'])->send(new UserActionsEmailNotify($data));

        } else if ($type === 'volunteering') {
            $activity_id = $this->data['data']['activity_id'] ?? 0;
            $post = VolunteeringActivity::select('volunteering_activities.*', 'users.name as organize_name', 'users.image as organize_image')
                ->join('users', 'users.id', 'volunteering_activities.user_id')
                ->join('user_types', 'user_types.user_id', 'users.id')
                ->where('user_types.type_user_id', $this->getTypeUserId('organize'))
                ->whereIn('volunteering_activities.status', ['live', 'closed'])
                ->where('users.status', 'approved')
                ->where('volunteering_activities.id', $activity_id)->first();

            $data['from'] = $this->settings['email'];
            $data['subject'] = 'New Report Abuse Information | ' . $this->settings['site_name'];
            $data['user_name'] = 'Dear ' . $this->settings['site_name'];
            $data['content_text'] = "You are receiving this email because we received a new report abuse <b>Volunteering Activity</b> information on your site.<br> Email: {$this->data['email']}<br>Reason: {$this->data['reason']}.";
            $link = route('get.home.volunteer.activity', $activity_id);
            $data['bottom_text'] = 'If you did not request to check it now, no further action is required.';
            $data['button_text'] = isset($post) ? 'See the volunteering activity.' : 'No volunteering activity for now.';
            $data['button_link'] = $link;
            $data['footer_text'] = 'If you’re having trouble clicking the button, copy and paste the URL below into your web browser: ' . $link;
            Mail::to($this->settings['email'])->send(new UserActionsEmailNotify($data));
        }
    }
}
