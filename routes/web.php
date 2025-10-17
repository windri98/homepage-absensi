<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Welcome page
// Route::get('/', [AuthController::class, 'welcome'])->name('welcome');

// Authentication routes
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes (require authentication)
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Attendance routes
    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/clock-in', [AttendanceController::class, 'showClockIn'])->name('clock-in');
        Route::post('/clock-in', [AttendanceController::class, 'clockIn'])->name('clock-in.store');
        Route::get('/clock-out', [AttendanceController::class, 'showClockOut'])->name('clock-out');
        Route::post('/clock-out', [AttendanceController::class, 'clockOut'])->name('clock-out.store');
        Route::get('/overtime', [AttendanceController::class, 'showOvertime'])->name('overtime');
        Route::post('/overtime', [AttendanceController::class, 'overtime'])->name('overtime.store');
        Route::get('/qr-scan', [AttendanceController::class, 'showQrScan'])->name('qr-scan');
        Route::get('/history', [AttendanceController::class, 'history'])->name('history');
        Route::get('/leave', [AttendanceController::class, 'showLeaveRequest'])->name('leave');
    });

    // Task routes
    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('index');
        Route::get('/create', [TaskController::class, 'create'])->name('create');
        Route::post('/', [TaskController::class, 'store'])->name('store');
        Route::get('/{task}', [TaskController::class, 'show'])->name('show');
        Route::patch('/assignments/{assignment}/status', [TaskController::class, 'updateStatus'])->name('assignments.status');
        Route::get('/manage/all', [TaskController::class, 'manage'])->name('manage');
        Route::get('/{task}/edit', [TaskController::class, 'edit'])->name('edit');
        Route::put('/{task}', [TaskController::class, 'update'])->name('update');
        Route::delete('/{task}', [TaskController::class, 'destroy'])->name('destroy');
    });

    // Profile routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::patch('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    });
});
