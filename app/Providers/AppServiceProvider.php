<?php

namespace App\Providers;

use App\Models\BlogCategory;
use App\Models\Room;
use App\Observers\BlogCategoryObserver;
use App\Observers\RoomObserver;
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
        Room::observe(RoomObserver::class);
        BlogCategory::observe(BlogCategoryObserver::class);
    }
}