<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
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

        // sebenarnya logic yang ada di gate ini sama dengan yang ada di middleware IsAdmin,
        // cuma ngga perlu ngecek sudah login atau belum karena gate ini konsepnya kalau user sudah login
        // dia bisa lakukan apa
        Gate::define('admin', function (User $user) {
            // return $user->username === 'louisfernando';

            // ini biar lebih fleksibel jika ada admin yang berubah/bertambah
            // (nambahin kolom buat ngecek admin atau bukan dengan tipe data boolean)
            return $user->is_admin;
            // ini akan ngecek kalau nilai 1 yaitu true makan gate boleh diakses kalau false ngga boleh
        });
    }
}
