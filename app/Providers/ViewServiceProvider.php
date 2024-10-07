<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Models\RelatedNewsSite;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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
        // share related sites
        $related_sites = RelatedNewsSite::select('name','url')->get();
        $categories = Category::select('name','slug','id')->get();



         $latest_posts =  Cache::get('latest_posts');
         $greatest_posts_comments = Cache::get('greatest_posts_comments');
        view()->share([
            'related_sites' => $related_sites,
            'categories' => $categories,
        ]);
    }
}
