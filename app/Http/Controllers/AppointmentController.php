<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{


    //TODO Hacer que la cita creada para un usuario, aparezca en el apartado "tus citas"

    //TODO crear confirmacion de cita y recordatorio que lleguen al email del usuario.

    //TODO Eliminar todo lo que no se vaya a usar para que el proyecto quede más limpio.

    //TODO Arreglar tooodas las vistas para que se vean bonitas (welcomeKokoRosa, login, signup, profile, services. dayselection, timeselection, confirmation, citacreadaconexito)

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

            $error = null;
            // Verificar si la fecha seleccionada es un sábado (día 6) o un domingo (día 0)
            if ($dayOfWeek === Carbon::SATURDAY || $dayOfWeek === Carbon::SUNDAY) {
                $error = 'No se pueden pedir citas los fines de semana.';
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
            $finallyAvailableHours = array_diff($allHours, $bookedHours->toArray());
            
            if ($error != null) {

                // Si hay un error, devuelve la vista con el mensaje de error
                return view('daySelection', ['error' => $error]);
            } else {
                return view('daySelection', ['finallyAvailableHours' => $finallyAvailableHours, 'date' => $selectedDate]);
            }
        } catch (\Exception $e) {

            return view('error');
        }
    }

    public function getConfirmation(Request $request)
    {
        $service = $request->input('service');
        $date = $request->input('date');
        $hour = $request->input('hour');

        return view('confirmation', [
            'service' => $service,
            'date' => $date,
            'hour' => $hour
        ]);
    }
    public function getDaySelection(Request $request)
    {
        $service = $request->input('service');
        return view('daySelection', ['service' => $service]);
    }

    public function createAppointment(Request $request)
    {

        $customer = $request->user();
        $service = $request->input('service');
        $date = $request->input('date');
        $selectedDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $date);
        $service = Service::where('name', $service)->first();
        $employee = Employee::find(1);


        $appointment = new Appointment();
        $appointment->cancelled = false;
        $appointment->date = $selectedDateTime;
        $appointment->customer()->associate($customer);
        $appointment->service()->associate($service);
        $appointment->employee()->associate($employee);
        $appointment->save();
        return view('yourAppointments', ['appointment' => $appointment->date]);
    }
}
