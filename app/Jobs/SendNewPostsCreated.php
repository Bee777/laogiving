<?php

namespace App\Jobs;

use App\Mail\UserActionsEmailNotify;
use App\Models\NewsLetter;
use App\Models\Site;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendNewPostsCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $post;
    protected $send_letter = false;
    protected $settings;

    /**
     * Create a new job instance.
     *
     * @param $post
     */
    public function __construct($post, $send_letter)
    {
        $this->post = $post;
        $this->send_letter = $send_letter;
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
        if ($this->send_letter) {
            $postType = ucfirst($this->post->type);
            $data['from'] = $this->settings['email'];
            $data['subject'] = 'New ' . $postType . ' Posted | ' . $this->settings['site_name'];
            $data['content_text'] = "You are receiving this email because we received a new {$postType} posted on {$this->settings['site_name']} Website.<br><br>{$postType} title: {$this->post->title}.";
            $link = route('get.home.posts.single', ['news', $this->post->id]);
            $data['bottom_text'] = 'If you did not request to check it now, no further action is required.';
            $data['button_text'] = 'Check the post now';
            $data['button_link'] = $link;
            $data['footer_text'] = 'If you’re having trouble clicking the button, copy and paste the URL below into your web browser: ' . $link;
            $newLetters = NewsLetter::all();
            foreach ($newLetters as $newLetter) {
                $data['user_name'] = 'Dear ' . $newLetter->email;
                Mail::to($newLetter->email)->send(new UserActionsEmailNotify($data));
            }
            $users_news_letter = User::where('receive_news', 'yes')->whereIn('status', ['pending', 'approved'])->get();
            foreach ($users_news_letter as $user_news_letter) {
                $data['user_name'] = 'Dear ' . $user_news_letter->name;
                Mail::to($user_news_letter->email)->send(new UserActionsEmailNotify($data));
            }
        } else {
            $postType = ucfirst($this->post->type);
            $data['from'] = $this->settings['email'];
            $data['subject'] = 'New ' . $postType . ' Posted | ' . $this->settings['site_name'];
            $data['user_name'] = 'Dear ' . $this->settings['site_name'];
            $data['content_text'] = "You are receiving this email because we received a new {$postType} posted on your site.<br><br>{$postType} title: {$this->post->title}.";
            $link = route('admin.get.' . $this->post->type);
            $data['bottom_text'] = 'If you did not request to check it now, no further action is required.';
            $data['button_text'] = 'Check the post now';
            $data['button_link'] = $link;
            $data['footer_text'] = 'If you’re having trouble clicking the button, copy and paste the URL below into your web browser: ' . $link;
            Mail::to($this->settings['email'])->send(new UserActionsEmailNotify($data));
        }
    }
}
