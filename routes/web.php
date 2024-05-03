<?php

use App\Http\Controllers\ServiceController;
//use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::controller(ServiceController::class)->group(function () {

    Route::get('/services', 'getServicesView');
    Route::get('/services/{id}', 'getServiceById');
    
});
Route::controller(CustomerController::class)->group(function () {

    Route::get('/profile', 'getCustomerById');
    
    
});
Route::get('/daySelection', function () {
    return view('daySelection');
});

Route::controller(AppointmentController::class)->group(function () {

    Route::post('/appointments', 'AppointmentsAvailable');
    Route::get('/appointments/{id}', 'getAppointmentById');
    //Route::post('/appointments', 'createAppointments');
    Route::put('/appointments/{id}', 'cancelAppointment');
    Route::get('/timeSelection','timeSelection');
    
});

Route::controller(ReminderController::class)->group(function () {

    Route::post('/reminders', 'createReminder');
    Route::get('/reminders/{appointment_id}', 'getReminder');

});






