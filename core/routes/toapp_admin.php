<?php

use App\Http\Controllers\ToappAdmin\AuthController;
use App\Http\Controllers\ToappAdmin\DashboardController;
use App\Http\Controllers\ToappAdmin\DepositController;
use App\Http\Controllers\ToappAdmin\MethodController;
use App\Http\Controllers\ToappAdmin\PlanController;
use App\Http\Controllers\ToappAdmin\ReadinessController;
use App\Http\Controllers\ToappAdmin\ReportController;
use App\Http\Controllers\ToappAdmin\SettingController;
use App\Http\Controllers\ToappAdmin\SupportController;
use App\Http\Controllers\ToappAdmin\UserController;
use App\Http\Controllers\ToappAdmin\WithdrawalController;
use Illuminate\Support\Facades\Route;

Route::middleware('toapp.admin.guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('toapp.admin')->name('logout');

Route::middleware('toapp.admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::post('/users/{user}/status', [UserController::class, 'status'])->name('users.status');
    Route::post('/users/{user}/verification', [UserController::class, 'verification'])->name('users.verification');
    Route::post('/users/{user}/balance', [UserController::class, 'balance'])->name('users.balance');

    Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
    Route::post('/plans', [PlanController::class, 'store'])->name('plans.store');
    Route::put('/plans/{plan}', [PlanController::class, 'update'])->name('plans.update');
    Route::post('/plans/{plan}/status', [PlanController::class, 'status'])->name('plans.status');

    Route::get('/deposits', [DepositController::class, 'index'])->name('deposits.index');
    Route::get('/deposits/{deposit}', [DepositController::class, 'show'])->name('deposits.show');
    Route::post('/deposits/{deposit}/approve', [DepositController::class, 'approve'])->name('deposits.approve');
    Route::post('/deposits/{deposit}/reject', [DepositController::class, 'reject'])->name('deposits.reject');

    Route::get('/withdrawals', [WithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::get('/withdrawals/{withdrawal}', [WithdrawalController::class, 'show'])->name('withdrawals.show');
    Route::post('/withdrawals/{withdrawal}/approve', [WithdrawalController::class, 'approve'])->name('withdrawals.approve');
    Route::post('/withdrawals/{withdrawal}/reject', [WithdrawalController::class, 'reject'])->name('withdrawals.reject');

    Route::get('/reports/transactions', [ReportController::class, 'transactions'])->name('reports.transactions');
    Route::get('/reports/investments', [ReportController::class, 'investments'])->name('reports.investments');
    Route::get('/reports/logins', [ReportController::class, 'logins'])->name('reports.logins');

    Route::get('/support', [SupportController::class, 'index'])->name('support.index');
    Route::get('/support/{ticket}', [SupportController::class, 'show'])->name('support.show');
    Route::post('/support/{ticket}/reply', [SupportController::class, 'reply'])->name('support.reply');
    Route::post('/support/{ticket}/close', [SupportController::class, 'close'])->name('support.close');

    Route::get('/methods', [MethodController::class, 'index'])->name('methods.index');
    Route::put('/methods/deposit/{gateway}', [MethodController::class, 'updateDepositGateway'])->name('methods.deposit.update');
    Route::put('/methods/withdraw/{method}', [MethodController::class, 'updateWithdrawMethod'])->name('methods.withdraw.update');
    Route::post('/methods/deposit/{gateway}/status', [MethodController::class, 'toggleDepositGateway'])->name('methods.deposit.status');
    Route::post('/methods/withdraw/{method}/status', [MethodController::class, 'toggleWithdrawMethod'])->name('methods.withdraw.status');

    Route::get('/readiness', [ReadinessController::class, 'index'])->name('readiness.index');

    Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
});
