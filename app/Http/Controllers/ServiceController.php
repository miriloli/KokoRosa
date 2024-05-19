<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Service;



class ServiceController extends Controller
{
    
    public function getServicesView()
    {
        try {
            $services = Service::all();
            if ($services !== null) {
                return view('services', ['services' => $services]);
            } else {
                return view('services', ['error' => 'Error. No services']);
            }
        } catch (\Exception $e) {
            return view('services', ['error' => 'Error. No services']);
        }
    }
}
