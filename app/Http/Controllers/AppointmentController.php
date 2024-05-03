<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            
            $daysAvailable = $this->getDaysAvailable();
            if (!in_array($date, $daysAvailable)) {
                return view('');
            }


            $hoursAvailable = $this->getHoursAvailable($date);


            /* if (!in_array($hour, $hoursAvailable)) {
            return view('');
        }*/


            return view('confirmation', compact('date', 'hour'));
        } catch (\Exception $e) {
        }
    }
    public function getHoursAvailable($date)
    {
        try {

            $HoursAvailable = [];


            $morningHours = ['10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30'];
            $afternoonHours = ['16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30'];
            $appointments = Appointment::table('appointments')
                ->where('date', $date)
                ->get();


            foreach ($morningHours as $hour) {

                if (!$this->appointmentExists($appointments, $hour)) {
                    $HoursAvailable[] = $hour;
                }
            }

            foreach ($afternoonHours as $hour) {
                if (!$this->appointmentExists($appointments, $hour)) {
                    $HoursAvailable[] = $hour;
                }
            }

            return $HoursAvailable;
        } catch (\Exception $e) {
        }
    }
    private function appointmentExists($appointments, $hour)
    {
        foreach ($appointments as $appointment) {
            if ($appointment->hour === $hour) {
                return true;
            }
        }
        return false;
    }
    public function getDaysAvailable()
    {
        try {
            $daysAvailable = [];
            $today = Carbon::now();
            $weekend = $today->copy()->endOfWeek();

            while ($today->lte($weekend)) {
                if ($today->isWeekday()) {
                    $daysAvailable[] = $today->format('d-m-y');
                }
                $today->addDay();
            }

            return $daysAvailable;
        } catch (\Exception $e) {
        }
    }
}
