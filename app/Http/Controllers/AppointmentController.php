<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
    }

    public function AppointmentsAvailable(Request $request)
    {
        try {
            $date = $request->input('date');

            $hoursAvailable = $this->getHoursAvailable($date);
            
            return $hoursAvailable;

        } catch (\Exception $e) {
            return view('error');
        }
    }
    public function getHoursAvailable($date)
    {
        try {
            $morningHours = ['10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30'];
            $afternoonHours = ['16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30'];

            $appointments = Appointment::whereDate('date', $date)->get();

            $bookedHours = $appointments->pluck('hour')->toArray();
            
            $availableHours = [];

            foreach ($morningHours as $hour) {
                if (!in_array($hour, $bookedHours)) {
                    $availableHours[] = $hour;
                }
            }

            foreach ($afternoonHours as $hour) {
                if (!in_array($hour, $bookedHours)) {
                    $availableHours[] = $hour;
                }
            }

            return $availableHours;
        } catch (\Exception $e) {
            return [];
        }
    }

    /*public function getDaysAvailable()
    {
        try {
            $daysAvailable = [];
            $today = Carbon::now();
            $weekend = $today->copy()->endOfWeek();

            while ($today->lte($weekend)) {
                if ($today->isWeekday()) {
                    $daysAvailable[] = $today->format('yyyy-mm-dd');
                }
                $today->addDay();
            }

            return $daysAvailable;
        } catch (\Exception $e) {
            return [];
        }
    }*/

    public function timeSelection(){
        return view('timeSelection');
    }
}
