<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{

    

    //TODO Arreglar tooodas las vistas para que se vean bonitas (welcomeKokoRosa, login, signup, profile, services. dayselection, timeselection, confirmation, citacreadaconexito)

    //TODO Hacer que la cita creada para un usuario, aparezca en el apartado "tus citas"

    //TODO Arreeglar el tema de que cuando se hace click en una hora disponible no navega hasta la vista "confirmation" (404)

    //TODO crear confirmacion de cita y recordatorio que llegueN al email del usuario.

    //TODO Eliminar todo lo que no se vaya a usar para que el proyecto quede más limpio.

    //TODO Hay que gestionar bien el tema de que el usuario seleccione una fecha el fin de semana
    //si bien el programa no deja selecionar el finde, tampoco hace nada de momento, y el problema es que una vez que
    // se ha seleccionado un dia del fin de semana, cuando se va a intentar elegir otra fecha, ya no funciona, 
    //ya no devuelve horas.


    public function availableHours(Request $request)
    {
        try {

            //Obtenemos la fecha seleccionada del calendario del fichero HTML
            $selectedDate = $request->input('date');

            // Convertimos la fecha seleccionada a un objeto Carbon para obtener el día de la semana
            $selectedDateTime = Carbon::parse($selectedDate);
            $dayOfWeek = $selectedDateTime->dayOfWeek;

            // Verificar si la fecha seleccionada es un sábado (día 6) o un domingo (día 0)
            if ($dayOfWeek === Carbon::SATURDAY || $dayOfWeek === Carbon::SUNDAY) {

                // mostrar un mensaje indicando que no se pueden pedir citas los fines de semana
                return redirect()->back()->with('error', 'No se pueden pedir citas los fines de semana.');
            }


            //Usamos Eloquent para buscar todas las citas existentes en la base de datos para la fecha seleccionada y extraer solo las fechas como un array
            $existingAppointments = Appointment::whereDate('date', $selectedDate)->pluck('date');

            //Iteramos sobre la colección de fechas existentes y convertimos cada una en una cadena de hora utilizando Carbon. Esta línea crea una colección de las horas reservadas.
            $bookedHours = $existingAppointments->map(function ($dateTime) {
                return Carbon::parse($dateTime)->format('H:i:s');
            });

            //Creamos un rango de horas desde las 10:00 hasta las 20:00 con un intervalo de 30 min
            $allHours = [];
            $startHour = Carbon::parse('10:00:00');
            $endHour = Carbon::parse('20:00:00');
            $interval = 30;
            $currentHour = $startHour->copy();

            //Usamos un bucle while para crear un array $allHours con todas las horas dentro del rango especificado.
            while ($currentHour < $endHour) {
                $allHours[] = $currentHour->format('H:i:s');
                $currentHour->addMinutes($interval);
            }

            // Eliminamos las horas donde no se trabaja (de 14:00 a 16:00)
            unset($allHours[8]);
            unset($allHours[9]);
            unset($allHours[10]);
            unset($allHours[11]);

            // Filtramos las horas disponibles
            $finallyAvailableHoursWithSeconds = array_diff($allHours, $bookedHours->toArray());

            //Eliminamos los segundos para que se vea mas limpio en la vista
            $finallyAvailableHours = array_map(function ($hour) {

                return substr($hour, 0, 5); // Eliminamos los últimos tres caracteres (segundos)
            }, $finallyAvailableHoursWithSeconds);

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
