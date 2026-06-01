<?php

namespace App\Providers;

use App\Models\BellPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $nextBell = BellPeriod::where('status', 'Next')->orderBy('sort_order')->first();
                $view->with('_nextBell', $nextBell);
            }
        });
    }
}
