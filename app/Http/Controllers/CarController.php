<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Car;

class CarController extends BaseController
{



    public function index()
    {
        $car = Car::get();
        return $this->sendResponse($car);
    }

    // ------------------------------
    public function show($id)
    {
        $car  = Car::find($id);

        if (!$car) {
            return $this->sendError("not found");
        }


        return $this->sendResponse($car, "success");
    }

    // -------------------store------------------------------


    public function store(Request $request)
    {

        $validated =  $this->validate($request, [
            'type' => 'required|min:2|max:150',
            'model' => 'required|min:2|max:150',
            'category' => 'required|min:2|max:150',
            'email' => 'required|email',
            "address" => "required|min:2|max:225",
            "mobile" => "required|digits_between:5,15",
            "price" => "required|numeric",
            "photo" => "nullable|image|mimes:png,jpg,jpeg|max:2048",
            "vr_video" => "nullable|string" // for now

        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $name = $photo->hashName();
            $photo->move("images/car",$name);
            $validated['photo'] = "images/car/" . $name;
        }

        $car = Car::create($validated);
        return $this->sendResponse($car, "success");
    }



    // -------------------update-------------------------------


    public function update($id, Request $request)
    {
        $car  = Car::find($id);

        if (!$car) {
            return $this->sendError("not found");
        }



        $validated =  $this->validate($request, [
            'type' => 'required|min:2|max:150',
            'model' => 'required|min:2|max:150',
            'category' => 'required|min:2|max:150',
            'email' => 'required|email',
            "address" => "required|min:2|max:225",
            "mobile" => "required|digits_between:5,15",
            "price" => "required|numeric",
            "photo" => "nullable|image|mimes:png,jpg,jpeg|max:2048",
            "vr_video" => "nullable|string" // for now

        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $name = $photo->hashName();
            $photo->move("images/car",$name);
            $validated['photo'] = "images/car/" . $name;

            $path = base_path("public") . "/" . $car->photo;
            $this->deleteFile($path);
        }




        $car->update($validated);

        return $this->sendResponse($car, "success update");
    }


    // -----------------------delete--------------------------


    public function delete($id)
    {
        $car  = Car::find($id);

        if (!$car) {
            return $this->sendError("not found");
        }


        $path = base_path("public") . "/" . $car->photo;
        $this->deleteFile($path);

        $car->delete();

        return $this->sendResponse(null, "success delete");
    }



    //
}
