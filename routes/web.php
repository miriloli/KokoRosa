<?php

use App\Http\Controllers\ServiceController;
//use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ReminderController;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return view('home');
});

Route::controller(ServiceController::class)->group(function () {

    Route::get('/services', 'getServices');
    Route::get('/services/{id}', 'getServiceById');
});

Route::controller(AppointmentController::class)->group(function () {

    Route::get('/appointments', 'getAppointments');
    Route::get('/appointments/{id}', 'getAppointmentById');
    Route::post('/appointments', 'createAppointments');
    Route::put('/appointments/{id}', 'cancelAppointment');
});

Route::controller(ReminderController::class)->group(function () {

    Route::post('/reminders', 'createReminder');
    Route::get('/reminders/{appointment_id}', 'getReminder');

});






