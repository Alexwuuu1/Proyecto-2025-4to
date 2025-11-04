<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CalendarController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('activities', ActivityController::class);
    Route::resource('donations', DonationController::class);
    Route::resource('certificates', CertificateController::class);
    Route::get('certificates/{certificate}/download', [CertificateController::class, 'download'])->name('certificates.download');
    Route::get('validate-certificate', [CertificateController::class, 'showValidateForm'])->name('certificates.validate-form');
    Route::post('validate-certificate', [CertificateController::class, 'validateCertificate'])->name('certificates.validate');

    Route::resource('rankings', RankingController::class);
    Route::post('rankings/update-all', [RankingController::class, 'updateAll'])->name('rankings.update-all');

    // Calendar routes
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/calendar/activities', [CalendarController::class, 'getActivities'])->name('calendar.activities');
    Route::get('/calendar/activities/{activity}', [CalendarController::class, 'show'])->name('calendar.show');
    Route::post('/calendar/activities/{activity}/join', [CalendarController::class, 'join'])->name('calendar.join');
    Route::post('/calendar/activities/{activity}/leave', [CalendarController::class, 'leave'])->name('calendar.leave');

    // Rutas administrativas
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

        Route::get('/activities', [AdminController::class, 'activities'])->name('activities');
        Route::post('/activities/{activity}/approve', [AdminController::class, 'approveActivity'])->name('activities.approve');
        Route::post('/activities/{activity}/reject', [AdminController::class, 'rejectActivity'])->name('activities.reject');
        Route::get('/activities/{activity}/edit', [AdminController::class, 'editActivity'])->name('activities.edit');
        Route::put('/activities/{activity}', [AdminController::class, 'updateActivity'])->name('activities.update');

        Route::get('/certificates', [AdminController::class, 'certificates'])->name('certificates');
        Route::get('/certificates/create', [AdminController::class, 'createCertificate'])->name('certificates.create');
        Route::post('/certificates', [AdminController::class, 'storeCertificate'])->name('certificates.store');

        Route::get('/donations', [AdminController::class, 'donations'])->name('donations');
        Route::post('/donations/{donation}/approve', [AdminController::class, 'approveDonation'])->name('donations.approve');
        Route::post('/donations/{donation}/reject', [AdminController::class, 'rejectDonation'])->name('donations.reject');

        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    });
});

require __DIR__.'/auth.php';
