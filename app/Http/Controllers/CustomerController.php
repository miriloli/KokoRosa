<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;




class CustomerController extends Controller
{
   


    public function getCustomerById(){


        try {
            $id=1;
            if ($id !== null) {

                $customer = Customer::where('id', $id)->first();
                if ($customer !== null) {
                    return view('profile', ['customer' => $customer]);
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
}
