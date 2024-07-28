<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; 
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

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
        //
        Paginator::useBootstrapFive();

        View::composer('layouts.navbars.auth.topnav', function ($view) {
            $userId = Auth::id();
            $currentRoute = Route::currentRouteName();

            // Hapus session jika route bukan halaman notifikasi
            if ($currentRoute !== 'notification') {
                session()->forget('notifications_read');
            }

            $hasNewNotifications = Notification::where('id', $userId)
                                                ->where('is_read', false)
                                                ->exists();

            $unreadNotificationsCount = Notification::where('id', $userId)
                                                    ->where('is_read', false)
                                                    ->count();

            $view->with('hasNewNotifications', $hasNewNotifications)
                 ->with('unreadNotificationsCount', $unreadNotificationsCount);
        });

        View::composer('layouts.navbars.auth.sidenav', function ($view) {
            $unreadAdminRequestsCount = Notification::where('type', 'admin request')
                ->where('is_read', false)
                ->count();
            $view->with('unreadAdminRequestsCount', $unreadAdminRequestsCount);
        });
    }
}
