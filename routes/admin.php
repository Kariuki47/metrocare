<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace'  => 'App\Http\Controllers\Admin',
    'prefix'     => 'admin',
    'middleware' => [
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ],
], function () {
    Route::resource('user', 'UserController')->except([
        'show'
    ]);
    Route::post('delete-user', 'UserController@destroyMany')->name('bulk.delete.user');
    Route::resource('role', 'RoleController')->except([
        'show'
    ]);
    Route::post('delete-role', 'RoleController@destroyMany')->name('bulk.delete.role');
    Route::resource('permission', 'PermissionController')->except([
        'show'
    ]);
    Route::post('delete-permission', 'PermissionController@destroyMany')->name('bulk.delete.permission');
    Route::resource('menu', 'MenuController')->except([
        'show'
    ]);
    Route::post('delete-menu', 'MenuController@destroyMany')->name('bulk.delete.menu');
    Route::resource('menu.item', 'MenuItemController')->except([
        'show'
    ]);
    Route::post('delete-menu-item', 'MenuItemController@destroyMany')->name('bulk.delete.menu.item');
    Route::resource('patient', 'PatientController')->except([
        'show'
    ]);
    Route::get('patient/examination-conclusion/{id}', 'PatientController@examinationConclusion')->name('admin.examination.conclusion');
    Route::post('examination-conclusion/{id}', 'PatientController@examinationConclusionStore')->name('admin.examination.conclusion.store');
    Route::post('delete-patient', 'PatientController@destroyMany')->name('bulk.delete.patient');
    Route::get('export-patients', 'PatientController@patientData')->name('export.patients');
    Route::resource('patient/blood-pressure', 'BloodPressureController', ['names' => 'blood-pressure']);
    Route::resource('patient/cardiovascular-system', 'CardiovascularSystemController', ['names' => 'cardiovascular-system']);
    Route::resource('patient/central-nervous-system', 'CentralNervousSystemController', ['names' => 'central-nervous-system']);
    Route::resource('patient/chest-x-ray', 'ChestXRaysController', ['names' => 'chest-x-ray']);
    Route::resource('patient/ecg', 'ECGController', ['names' => 'ecg']);
    Route::resource('patient/family-history', 'FamilyHistoryController', ['names' => 'family-history']);
    Route::resource('patient/gastro-intestinal', 'GastrointestinalSystemController', ['names' => 'gastro-intestinal']);
    Route::resource('patient/general-appearance', 'GeneralAppearanceController', ['names' => 'general-appearance']);
    Route::resource('patient/genito-urinary-system', 'GenitoUrinarySystemController', ['names' => 'genito-urinary-system']);
    Route::resource('patient/past-medical-history', 'PastMedicalHistoryController', ['names' => 'past-medical-history']);
    Route::resource('patient/respiratory-system', 'RespiratorySystemController', ['names' => 'respiratory-system']);
    Route::resource('patient/sensory-organ', 'SensoryOrganController', ['names' => 'sensory-organ']);
    Route::resource('patient/skeletal-system', 'SkeletalSystemController', ['names' => 'skeletal-system']);
    Route::resource('patient/skin-teguments', 'SkinTegumentsController', ['names' => 'skin-teguments']);
    Route::resource('patient/social-history', 'SocialHistoryController', ['names' => 'social-history']);
    Route::get('patient/lab-report/{id}', 'LabReportController@labReport')->name('lab.report');
    Route::post('lab-report-upload/', 'LabReportController@labReportUpload')->name('lab.report.upload');
    Route::get('lab-report/{id}/download', 'LabReportController@downloadReport')->name('lab.report.download');
    Route::post('lab-report-delete', 'LabReportController@deleteReport')->name('lab.report.delete');
});
