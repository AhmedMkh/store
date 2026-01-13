<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Support\Facades\Event;
use App\Models\Dashboard\Category;
use App\Observers\CategoryObserver;
use App\Models\Dashboard\Subcategory;
use App\Observers\SubcategoryObserver;

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
        Event::listen(
            Registered::class,
            SendEmailVerificationNotification::class
        );

        // 2. نقل الـ Observers كما هي
        Category::observe(CategoryObserver::class);
        Subcategory::observe(SubcategoryObserver::class);
    }
}
