<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Client;

class ClientController extends BaseController
{



    public function index()
    {
        $clients = Client::get();
        return $this->sendResponse($clients);
    }

    // ------------------------------
    public function show($id)
    {
        $client  = Client::find($id);

        if (!$client) {
            return $this->sendError("not found");
        }


        return $this->sendResponse($client, "success");
    }

    // -------------------store------------------------------


    public function store(Request $request)
    {




        $validated =  $this->validate($request, [
            'payment_method' => 'required|min:2|max:150',
            "number_of_people" => "required|integer|digits_between:0,11",
            "price_per_person" => "required|numeric|digits_between:0,11",
            "booking_provider" => "required|numeric|digits_between:0,11",
            "total_paymnt" => "required|numeric|digits_between:0,11",
            'booking_date'  =>  'required|date',
            'departure_date'  =>  'required|date',



        ]);

        $validated['booking_date'] =  date('Y-m-d H:i:s', strtotime($request->booking_date));
        $validated['departure_date'] =  date('Y-m-d H:i:s', strtotime($request->departure_date));



        $client = Client::create($validated);
        return $this->sendResponse($client, "success");
    }



    // -------------------update-------------------------------


    public function update($id, Request $request)
    {
        $client  = Client::find($id);

        if (!$client) {
            return $this->sendError("not found");
        }



        $validated =  $this->validate($request, [
            'payment_method' => 'required|min:2|max:150',
            "number_of_people" => "required|integer|digits_between:0,11",
            "price_per_person" => "required|numeric|digits_between:0,11",
            "booking_provider" => "required|numeric|digits_between:0,11",
            "total_paymnt" => "required|numeric|digits_between:0,11",
            'booking_date'  =>  'required|date',
            'departure_date'  =>  'required|date',



        ]);

        $validated['booking_date'] =  date('Y-m-d H:i:s', strtotime($request->booking_date));
        $validated['departure_date'] =  date('Y-m-d H:i:s', strtotime($request->departure_date));




        $client->update($validated);

        return $this->sendResponse($client, "success update");
    }


    // -----------------------delete--------------------------


    public function delete($id)
    {
        $client  = Client::find($id);

        if (!$client) {
            return $this->sendError("not found");
        }


        $client->delete();

        return $this->sendResponse(null, "success delete");
    }



    //
}
