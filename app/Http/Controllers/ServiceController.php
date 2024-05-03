<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;


class ServiceController extends Controller
{
    public function getServices()
    {
        try {
            $services = Service::all();
            if ($services !== null) {
                return response()->json(['services' => $services], 200);
            } else {
                return response()->json(['error' => 'Error. No services'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error getting services: ' . $e->getMessage()], 500);
        }
    }
    public function getServiceById(string $id)
    {

        try {

            if ($id !== null) {

                $service = Service::where('id', $id)->first();
                if ($service !== null) {
                    return response()->json(['Service' => $service], 200);
                } else {
                    return response()->json(['error' => 'Error getting a service: '], 400);
                }
            } else {
                return response()->json(['error' => 'Error getting a service: '], 400);
            }
        } catch (\Exception $e) {

            return response()->json(['error' => 'Error getting a service' . $e->getMessage()], 500);
        }
    }
    public function getServicesView()
    {
        try {
            $services = Service::all();
            if ($services !== null) {
                return view('services', ['services' => $services]);
            } else {
                return response()->json(['error' => 'Error. No services'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error getting services: ' . $e->getMessage()], 500);
        }
    }
}
