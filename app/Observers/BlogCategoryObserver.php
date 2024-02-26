<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\BlogCategory;

class BlogCategoryObserver
{
    /**
     * Handle the BlogCategory "created" event.
     */
    public function created(BlogCategory $blogCategory): void
    {
        //
    }

    public function creating(BlogCategory $blogCategory)
    {
        $blogCategory->slug = Str::slug($blogCategory->name);
    }

    /**
     * Handle the BlogCategory "updated" event.
     */
    public function updated(BlogCategory $blogCategory): void
    {
        //
    }

    public function updating(BlogCategory $blogCategory)
    {
        if ($blogCategory->isDirty('name')) {
            $blogCategory->slug = Str::slug($blogCategory->name);
        }
    }

    /**
     * Handle the BlogCategory "deleted" event.
     */
    public function deleted(BlogCategory $blogCategory): void
    {
        //
    }

    /**
     * Handle the BlogCategory "restored" event.
     */
    public function restored(BlogCategory $blogCategory): void
    {
        //
    }

    /**
     * Handle the BlogCategory "force deleted" event.
     */
    public function forceDeleted(BlogCategory $blogCategory): void
    {
        //
    }
}