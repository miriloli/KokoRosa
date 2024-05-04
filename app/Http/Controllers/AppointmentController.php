<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /* public function getAppointments()
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
    public function getAppointmentsView()
    {
        try {
            $appointments = Appointment::all();
            if ($appointments !== null) {
                return view('appointments', ['appointments' => $appointments]);
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

            $date = $request->input('appointmentDate');
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
    }*/

    public function availableHours(Request $request)
    {
        try {

            $selectedDate = $request->input('date');


            $date = Carbon::createFromFormat('Y-m-d', $selectedDate);

            $existingAppointments = Appointment::whereDate('date', $date)->pluck('date');

            $bookedHours = [];

            foreach ($existingAppointments as $date ) {
                $hour=explode(" ", $date)[1];
                $bookedHours = array_push($bookedHours, $hour);
            }
                                            //ejemlo 2024-05-04 10:00:00 

            $allHours = [];
            $startHour = Carbon::parse('10:00:00');
            $endHour = Carbon::parse('20:00:00');
            $interval = 30;
            $currentHour = $startHour->copy();
            while ($currentHour < $endHour) {

                if (!$existingAppointments->contains($currentHour)) {
                    $allHours[] = $currentHour->format('HH:MM:ss');
                }

                $currentHour->addMinutes($interval);
            }
            //aqui las tienes todas
            //$availableHours - $horas; esto no se hace asi

            
            unset($allHours[8]); 
            unset($allHours[9]); 
            unset($allHours[10]); 
            unset($allHours[11]); 

            $finallyAvailableHours = array_diff($allHours, $bookedHours);


            return view('timeSelection', ['finallyAvailableHours' => $finallyAvailableHours]);
        } catch (\Exception $e) {

            return view('error');
        }
    }

    public function timeSelection()
    {
        return view('timeSelection');
    }
}
