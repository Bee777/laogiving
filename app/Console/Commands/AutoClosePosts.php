<?php

namespace App\Console\Commands;

use App\Models\Posts;
use App\Models\VolunteeringActivity;
use Illuminate\Console\Command;

class AutoClosePosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:close {--types=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically to close posts types {events, scholarships} when it reached their expires time.';


    public function IsExpired($ctime): bool
    {
        date_default_timezone_set('Asia/Vientiane');
        return strtotime($ctime) <= time();
    }

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $event_posts = Posts::where('type', 'event')->where('status', 'open')->get();
        $scholarships_posts = Posts::where('type', 'scholarship')->where('status', 'open')->get();
        $volunteer_activities = VolunteeringActivity::where('status', 'live')->get();
        #events
        if (count($event_posts) > 0) {
            foreach ($event_posts as $post) {
                if ($this->IsExpired($post->deadline)) {
                    $post->status = 'close';
                    $post->save();
                    $this->info('The event is expired now, Post Id = ' . $post->id);
                }
            }
        }
        #scholarships posts
        if (count($scholarships_posts) > 0) {
            foreach ($scholarships_posts as $post) {
                if ($this->IsExpired($post->deadline)) {
                    $post->status = 'close';
                    $post->save();
                    $this->info('The scholarship is expired now, Post Id = ' . $post->id);
                }
            }
        }
        # volunteer activities posts
        if (count($volunteer_activities) > 0) {
            foreach ($volunteer_activities as $post) {
                if ($this->IsExpired($post->end_date)) {
                    $post->status = 'closed';
                    $post->save();
                    $this->info('The volunteer activity is expired now, Post Id = ' . $post->id);
                }
            }
        }
    }
}
