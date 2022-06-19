<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Validation\Rule;
use App\Http\Controllers\BaseController;

class ReservationController extends BaseController
{


    public function index()
    {
        $reservations =  Reservation::get();

        return $this->sendResponse($reservations);
    }


    // ------------------------------
    public function show($id)
    {

        $reservation  = Reservation::find($id);

        if (!$reservation) {
            return $this->sendError("not found");
        }

        return $this->sendResponse($reservation, "success");
    }


    // -------------------store------------------------------


    public function store(Request $request)
    {



        $validated =  $this->validate($request, [
            'name' => 'required|min:2|max:150',
            "address" => "required|min:2|max:225",
            "mobile" => "required|digits_between:5,15",
            "card_number" => "required|digits_between:0,11",
        ]);

        $reservation = Reservation::create($validated);
        return $this->sendResponse($reservation, "success");
    }



    // -------------------update-------------------------------


    public function update($id, Request $request)
    {
        $reservation  = Reservation::find($id);

        if (!$reservation) {
            return $this->sendError("not found");
        }



        $validated =  $this->validate($request, [
            'name' => 'required|min:2|max:150',
            "address" => "required|min:2|max:225",
            "mobile" => "required|digits_between:5,15",
            "card_number" => "required|digits_between:0,11",
        ]);

        $reservation->update($validated);

        return $this->sendResponse($reservation, "success update");
    }


    // -----------------------delete--------------------------


    public function delete($id)
    {
        $reservation  = Reservation::find($id);

        if (!$reservation) {
            return $this->sendError("not found");
        }


        $reservation->delete();

        return $this->sendResponse(null, "success delete");
    }



    //
}
