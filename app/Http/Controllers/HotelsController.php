<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Hotel;

class HotelsController extends BaseController
{



    public function index()
    {
        $hotels = Hotel::get();
        return $this->sendResponse($hotels);
    }

    // ------------------------------
    public function show($id)
    {
        $hotel  = Hotel::find($id);

        if (!$hotel) {
            return $this->sendError("not found");
        }


        return $this->sendResponse($hotel, "success");
    }

    // -------------------store------------------------------


    public function store(Request $request)
    {

        $validated =  $this->validate($request, [
            'name' => 'required|min:2|max:150',
            'email' => 'required|email',
            "address" => "required|min:2|max:225",
            "mobile" => "required|digits_between:5,15",
            "room_number" => "required|digits_between:0,20",
            "price" => "required|numeric",
            "photo" => "nullable|image|mimes:png,jpg,jpeg",
            "vr_video" => "nullable|string", // for now
            'room_type' => 'required|min:2|max:150',


        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $name = $photo->hashName();
            $photo->move("images/hotels",$name);
            $validated['photo'] = "images/hotels/" . $name;
        }

        $hotel = Hotel::create($validated);
        return $this->sendResponse($hotel, "success");
    }



    // -------------------update-------------------------------


    public function update($id, Request $request)
    {
        $hotel  = Hotel::find($id);

        if (!$hotel) {
            return $this->sendError("not found");
        }



        $validated =  $this->validate($request, [
            'name' => 'required|min:2|max:150',
            'email' => 'required|email',
            "address" => "required|min:2|max:225",
            "mobile" => "required|digits_between:5,15",
            "room_number" => "required|digits_between:0,20",
            "price" => "required|numeric",
            "photo" => "nullable|image|mimes:png,jpg,jpeg",
            "vr_video" => "nullable|string", // for now
            'room_type' => 'required|min:2|max:150',

        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $name = $photo->hashName();
            $photo->move("images/hotels",$name);
            $validated['photo'] = "images/hotels/" . $name;

            $path = base_path("public") . "/" . $hotel->photo;
            $this->deleteFile($path);
        }




        $hotel->update($validated);

        return $this->sendResponse($hotel, "success update");
    }


    // -----------------------delete--------------------------


    public function delete($id)
    {
        $hotel  = Hotel::find($id);

        if (!$hotel) {
            return $this->sendError("not found");
        }

        $path = base_path("public") . "/" . $hotel->photo;
        $this->deleteFile($path);


        $hotel->delete();

        return $this->sendResponse(null, "success delete");
    }



    //
}
