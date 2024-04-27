<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appoinment;
use Illuminate\Http\Request;

class AppoinmentController extends Controller
{
    public function getAppoinments()
    {
        try {
            $appoinments = Appoinment::all();
            if ($appoinments !== null) {
                return response()->json(['appoinments' => $appoinments], 200);
            } else {
                return response()->json(['error' => 'Error. No appoinments'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error. No appoinments'], 400);
        }
    }
    public function getAppoinmentById(string $id)
    {
        try {
            if ($id !== null) {

                $appoinment = Appoinment::find($id);
                if ($appoinment !== null) {
                    return response()->json(['Appoinment' => $appoinment], 200);
                } else {
                    return response()->json(['error' => 'Error getting an appoinment: '], 400);
                }
            } else {
                return response()->json(['error' => 'Error getting an appoinment: '], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error getting an appoinment: '], 500);
        }
    }
    public function createAppoinments(Request $request)
    {
        try {
          //TODO $idCostumer=$request-> Vendrá del login, estará en memoria.
          //TODO $idService=$request-> Vendrá de añadir el servicio
          
            $date=$request->input('appoimentDate');
            

        } catch (\Exception $e) {

        }
    }
    public function cancelAppoinment(string $id)
    {
        try {
            if ($id !== null) {

                $appoinment = Appoinment::find($id);
                if ($appoinment !== null) {
                    $appoinment->cancelled = true;
                    $appoinment->save();
                    return response()->json(['Appoinment' => $appoinment], 200);
                } else {
                    return response()->json(['error' => 'Error cancellig an appoinment: '], 400);
                }
            } else {
                return response()->json(['error' => 'Error cancellig an appoinment: '], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error cancellig an appoinment: '], 500);
        }
    }
}
