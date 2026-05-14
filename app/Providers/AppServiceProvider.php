<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

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
    // Akses khusus Owner (Contoh: Manajemen User)
    Gate::define('isOwner', function (User $user) {
        return $user->role === 'owner';
    });

    // Akses untuk Manager & Owner (Contoh: Menambah/Mengedit Barang)
    Gate::define('manage-inventory', function (User $user) {
        return in_array($user->role, ['owner', 'manager']);
    });

    // Akses untuk melakukan transaksi (Contoh: Kasir/Staf)
    Gate::define('make-transaction', function (User $user) {
        return in_array($user->role, ['owner', 'manager', 'staff']);
    });

    // Auditor dibiarkan tidak punya akses aksi di atas,
    // karena dia hanya butuh akses "melihat" (Read-Only) yang biasanya tidak di-Gate.
}
}
