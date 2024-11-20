<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApprovalFlowController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
})->name('home');

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
    Route::post('/register', [LoginController::class, 'register'])->name('register');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/applications/new', [ApplicationController::class, 'newApplication'])->name('newApplication');
    Route::get('/applications/ongoing', [ApplicationController::class, 'ongoingApplication'])->name('ongoingApplication');
    Route::get('/applications/completed', [ApplicationController::class, 'completedApplication'])->name('completedApplication');
    Route::get('/applications/rejected', [ApplicationController::class, 'rejectedApplication'])->name('rejectedApplication');
    Route::get('/applications/withdrawn', [ApplicationController::class, 'withdrawnApplication'])->name('withdrawnApplication');

    //for own applications
    Route::get('/myApplications_all', [ApplicationController::class, 'allApplication'])->name('allApplication');
    Route::get('/myApplications_approve', [ApplicationController::class, 'approvedApplication'])->name('approvedApplication');
    Route::get('/myApplications_rejected', [ApplicationController::class, 'rejectApplication'])->name('rejectApplication');
    Route::put('/withdrawApp/{app_id}', [ApplicationController::class, 'withdrawApp'])->name('withdrawApp');

    //for own applications request 
    Route::get('/request/new', [ApplicationController::class, 'newRequest'])->name('newRequest');
    Route::get('/request/submitted', [ApplicationController::class, 'submittedRequest'])->name('submittedRequest');
    Route::get('/request/completed', [ApplicationController::class, 'completedRequest'])->name('completedRequest');
    Route::get('/request/rejected', [ApplicationController::class, 'rejectedRequest'])->name('rejectedRequest');
    Route::get('/request/dept', [ApplicationController::class, 'deptRequest'])->name('deptRequest');

    //for update application tracking
    Route::put('/applications/{app_id}/updateTrack/{track_id}', [ApplicationController::class, 'updateTrackApplication'])->name('updateTrackApplication');
    Route::put('/applications/{app_id}/updateTrack/{track_id}/disbursed', [ApplicationController::class, 'updateDisbursement'])->name('updateDisbursement');

    // Route::get('/test/email/{app_id}', [ApplicationController::class, 'testemail'])->name('testemail');
    // Route::get('/test/currency/{currency_code}/{date}', [RoleController::class, 'test'])->name('test');

    //disbursement
    Route::get('/applications/disburse/{app_id}', [ApplicationController::class, 'disbursePage'])->name('disbursePage');
    Route::put('/applications/disburse/{app_id}', [ApplicationController::class, 'disbursement'])->name('disbursement');

    Route::get('/profile', [UserController::class, 'viewProfile'])->name('viewProfile');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('updateProfile');
    Route::get('/password', [UserController::class, 'viewPassword'])->name('viewPassword');
    Route::put('/password/update', [UserController::class, 'updatePassword'])->name('updatePassword');

    Route::get('/settings', [UserController::class, 'settings'])->name('settings');

    Route::post('/saveFlows/{role_id}', [ApprovalFlowController::class, 'saveFlows'])->name('saveFlows');
    Route::delete('/deleteFlow/{role_id}/{appFlow_id}', [ApprovalFlowController::class, 'deleteFlow'])->name('deleteFlow');

    Route::get('/report', [ReportController::class, 'view']);
    Route::post('/report', [ReportController::class, 'view']);

    Route::resource('users', 'UserController');
    Route::resource('centres', 'CentreController');
    Route::resource('roles', 'RoleController');
    Route::resource('audit', 'AuditTrailController');
    Route::resource('currencies', 'CurrencyController');
    Route::resource('itemTypes', 'TypeController');
    Route::resource('applications', 'ApplicationController');
});
