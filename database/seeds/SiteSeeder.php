<?php

use Illuminate\Database\Seeder;
use App\Models\Site;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Site::create(['key' => 'site_name', 'value' => 'The Management Website for Communication between Volunteers and Organizations']);

        Site::create(['key' => 'email', 'value' => 'info@giving.la']);

        Site::create(['key' => 'address', 'value' => 'Khamhoung, Xaythany District, Vientiane Capital, Laos PDR.']);

        Site::create(['key' => 'email_logo', 'value' => 'email_logo.png']);

        Site::create(['key' => 'fav_icon', 'value' => 'favicon.png']);

        Site::create(['key' => 'website_logo', 'value' => 'logo.png']);

        Site::create(['key' => 'fresh_version', 'value' => '?vc45c3b0892a8c650a95b4e2bf4cb1fa9']);
    }
}
