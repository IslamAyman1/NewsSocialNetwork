<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\RelatedNewsSite;
use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class CheckSettingProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
       $getSetting = Setting::firstOr(function (){
            return Setting::create([
                 'site_name' => 'news',
                 'logo' => '/img/logo.png',
                 'favicon' => 'default',
                 'email' => 'is606ay@gmail.com',
                 'facebook' => 'https://web.facebook.com/?_rdc=1&_rdr',
                 'twitter' => 'https://www.twitter.com',
                 'instagram' => 'https://www.instagram.com',
                 'youtube' => 'https://www.youtube.com',
                 'phone' => '01203751448',
                 'address' => 'Alex/30 Street',
                 'country' => 'Egypt',
                 'street' => '30 Street',
                 'city' => 'Alex',
            ]);
        });

       view()->share([
           'getSetting' => $getSetting,
       ]);
    }
}
