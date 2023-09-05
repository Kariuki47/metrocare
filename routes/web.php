<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportGeneratorController;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', [ProfileController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/activitylog', [ProfileController::class, 'activityLog'])->name('activitylog');
    Route::get('/settings/account', [ProfileController::class, 'accountSettings'])->name('account.settings.edit');
    Route::get('/settings/sessions', [ProfileController::class, 'settingsSessions'])->name('settings.sessions');
    Route::get('/settings/two-factor', [ProfileController::class, 'settingsTwoFactor'])->name('settings.two-factor');
});

Route::get('/patient-details', [ProfileController::class, 'patientDetails'])->name('patient.details');
Route::post('/patient-details', [ProfileController::class, 'addPatientDetails'])->name('add.patient.details');
Route::get('/thank-you', [ProfileController::class, 'thankYou'])->name('thank.you');

Route::get('/report/{id}', [ReportGeneratorController::class, 'index']);
Route::get('/report/pdf/{id}', [ReportGeneratorController::class, 'pdf'])->name('generatePDF');
Route::post('/bulkReport/pdf', [ReportGeneratorController::class, 'bulkPdf'])->name('bulkGeneratePDF');
