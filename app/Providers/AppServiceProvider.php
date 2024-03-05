<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Room;
use App\Models\BlogCategory;
use App\Observers\PostObserver;
use App\Observers\RoomObserver;
use Illuminate\Pagination\Paginator;
use App\Observers\BlogCategoryObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        Room::observe(RoomObserver::class);
        BlogCategory::observe(BlogCategoryObserver::class);
        Post::observe(PostObserver::class);
    }
}