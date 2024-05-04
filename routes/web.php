<?php

use App\Http\Controllers\ServiceController;
//use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcomeKokoRosa');
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
    Route::put('/appointments/{id}', 'cancelAppointment');
    Route::get('/timeSelection', 'timeSelection');
});

Route::controller(ReminderController::class)->group(function () {

    Route::post('/reminders', 'createReminder');
    Route::get('/reminders/{appointment_id}', 'getReminder');
});


Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
