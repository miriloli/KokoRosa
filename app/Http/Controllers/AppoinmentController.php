<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function getAppointments()
    {
        try {
            $appointments = Appointment::all();
            if ($appointments !== null) {
                return response()->json(['appointments' => $appointments], 200);
            } else {
                return response()->json(['error' => 'Error. No appointments'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error. No appointments'], 400);
        }
    }
    public function getAppointmentById(string $id)
    {
        try {
            if ($id !== null) {

                $appointment = Appointment::find($id);
                if ($appointment !== null) {
                    return response()->json(['Appointment' => $appointment], 200);
                } else {
                    return response()->json(['error' => 'Error getting an appointment: '], 400);
                }
            } else {
                return response()->json(['error' => 'Error getting an appointment: '], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error getting an appointment: '], 500);
        }
    }
    public function createAppointments(Request $request)
    {
        try {
          //TODO $idCostumer=$request-> Vendrá del login, estará en memoria.
          //TODO $idService=$request-> Vendrá de añadir el servicio
          
            $date=$request->input('appointmentDate');
            

        } catch (\Exception $e) {

        }
    }
    public function cancelAppointment(string $id)
    {
        try {
            if ($id !== null) {

                $appointment = Appointment::find($id);
                if ($appointment !== null) {
                    $appointment->cancelled = true;
                    $appointment->save();
                    return response()->json(['Appointment' => $appointment], 200);
                } else {
                    return response()->json(['error' => 'Error cancellig an appointment: '], 400);
                }
            } else {
                return response()->json(['error' => 'Error cancellig an appointment: '], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error cancellig an appointment: '], 500);
        }
    }
}
