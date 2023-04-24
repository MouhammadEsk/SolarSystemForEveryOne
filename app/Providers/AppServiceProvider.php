<?php

namespace App\Providers;

use App\Models\Feedback;
use App\Observers\FeedbackObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Schedule $schedule)
    {
        Schema::defaultStringLength(191);

        // Register the RatingObserver
        Feedback::observe(FeedbackObserver::class);

        $schedule->call(function () {
            $rating = new Feedback();
            $observer = new FeedbackObserver();
            $observer->updateMonthlyRatings($rating);
            Log::info('Monthly ratings update complete');
        })->monthlyOn(1, '00:00');
    }
}
