<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Collection;

class LoadNotifications
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ambil data notifikasi dari database
        $notifications = DB::table('notifications')->where('id', auth()->id())->get();

        // Pastikan $notifications adalah koleksi
        $notifications = collect($notifications);

        // Share notifikasi ke semua view
        View::share('notifications', $notifications);

        return $next($request);
    }
}
