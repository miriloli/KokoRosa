<?php

use App\Http\Controllers\ServiceController;
//use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AppoinmentController;
use App\Http\Controllers\ReminderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::controller(ServiceController::class)->group(function () {

    Route::get("/services", "getServices");
    Route::get("/services/{id}", "getServiceById");
});

Route::controller(AppoinmentController::class)->group(function () {

    Route::get("/appoinments", "getAppoinments");
    Route::get("/appoinments/{id}", "getAppoinmentById");
    Route::post("/appoinments", "createAppoinments");
    Route::put("/appoinments/{id}", "cancelAppoinment");
});

Route::controller(ReminderController::class)->group(function () {

    Route::post("/reminders", "createReminder");
    Route::get("/reminders/{appoinment_id}", "getReminder");

});






