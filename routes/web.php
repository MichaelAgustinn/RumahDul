<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasswordController;
use App\Http\Middleware\IsAdmin;
use App\Models\Module;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| AREA GUEST (Pencarian Modul)
|--------------------------------------------------------------------------
*/

Route::get('/', [ModuleController::class, 'index'])->name('modules.index');

Route::get('/modul/{module}/lihat', [ModuleController::class, 'viewPdf'])->name('modules.view');
Route::get('/modul/{module}/unduh', [ModuleController::class, 'downloadPdf'])->name('modules.download');
/*
|--------------------------------------------------------------------------
| AREA AUTENTIKASI (Login & Logout)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login-dosen', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login-dosen', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| AREA TERAUTENTIKASI (Dashboard Admin & Dosen)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard Utama (Menampilkan daftar modul sesuai Role)
    Route::get('/dashboard', function (\Illuminate\Http\Request $request) {

        // 1. Ambil Query dasar sesuai Role
        $query = auth()->user()->role === 'admin'
            ? Module::with('user')->latest()
            : auth()->user()->modules()->latest();

        // 2. Logika Pencarian (Mencari di seluruh database)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('mata_kuliah', 'like', "%{$search}%");
            });
        }

        // 3. Eksekusi Paginate dan simpan query string (agar parameter search terbawa di link paginasi)
        $modules = $query->paginate(10)->withQueryString();

        // 4. Ambil daftar dosen (Khusus admin)
        $dosens = auth()->user()->role === 'admin'
            ? User::where('role', 'dosen')->orderBy('name')->get()
            : collect();

        return view('dashboard.index', compact('modules', 'dosens'));
    })->name('dashboard');

    // Proses Upload & Hapus Modul (Untuk Admin & Dosen)
    Route::post('/modules', [ModuleController::class, 'store'])->name('modules.store');
    Route::delete('/modules/{module}', [ModuleController::class, 'destroy'])->name('modules.destroy');

    // Grouping khusus Admin Controller
    Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
        // Dashboard Utama
        Route::get('/dashboard', function () {
            $modules = auth()->user()->role === 'admin'
                ? Module::with('user')->latest()->get()
                : auth()->user()->modules()->latest()->get();

            return view('dashboard.index', compact('modules'));
        })->name('dashboard');

        Route::get('/statistic', [DashboardController::class, 'index'])->name('statistic.dashboard');

        Route::post('/modules', [ModuleController::class, 'store'])->name('modules.store');
        Route::delete('/modules/delete/{module}', [ModuleController::class, 'destroy'])->name('modules.destroy');
        Route::get('/modules/edit/{module}', [ModuleController::class, 'edit'])->name('modules.edit');
        Route::put('/modules/update/{module}', [ModuleController::class, 'update'])->name('modules.update');

        Route::get('/password/update', [PasswordController::class, 'edit'])->name('password.edit');
        Route::put('/password/update', [PasswordController::class, 'update'])->name('password.update');

        // Route::middleware([IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {

        // Manajemen Dosen
        Route::get('/users', [AdminController::class, 'indexUsers'])->name('users');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
        Route::patch('users/{user}/reset-password', [AdminController::class, 'resetPassword'])->name('users.reset-password');
        Route::patch('users/{user}/update-role', [AdminController::class, 'updateRole'])->name('users.update-role');

        // Pengaturan Konten Website
        Route::get('/web-content', [AdminController::class, 'editContent'])->name('content.edit');
        Route::put('/web-content', [AdminController::class, 'updateContent'])->name('content.update');
        // });
    });
});
