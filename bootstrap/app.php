<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route; // <--- WAJIB IMPORT INI

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            // ============================================================
            // 1. ROUTE BACKOFFICE (Area Manajemen Sekolah)
            // ============================================================
            // Diakses oleh: Super Admin, Staff TU, Guru (tugas tambahan), Bendahara
            Route::middleware(['web', 'auth', 'role:super-admin|staff-tu|guru|bendahara'])
                ->prefix('admin') // URL jadi: domain.com/admin/dashboard
                ->name('admin.')   // Nama route: admin.dashboard
                ->group(base_path('routes/admin.php'));

            // ============================================================
            // 2. ROUTE GURU (Area Akademik Mengajar)
            // ============================================================
            // Khusus tugas mengajar (input nilai, absensi kelas)
            Route::middleware(['web', 'auth', 'role:guru'])
                ->prefix('guru')
                ->name('guru.')
                ->group(base_path('routes/guru.php'));

            // ============================================================
            // 3. ROUTE MURID (Area Portal Siswa) - SUDAH UPDATE JADI MURID
            // ============================================================
            Route::middleware(['web', 'auth', 'role:murid'])
                ->prefix('murid')  // URL jadi: domain.com/murid/rapor
                ->name('murid.')
                ->group(base_path('routes/murid.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        // ============================================================
        // REGISTRASI ALIAS SPATIE PERMISSION
        // ============================================================
        // Agar kita bisa pakai 'role:admin' atau 'can:edit-data' di route
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();