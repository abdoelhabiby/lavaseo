<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Restaurant;

class RestaurantController extends BaseController
{



    public function index()
    {
        $restaurants = Restaurant::get();
        return $this->sendResponse($restaurants);
    }

    // ------------------------------
    public function show($id)
    {
        $restaurant  = Restaurant::find($id);

        if (!$restaurant) {
            return $this->sendError("not found");
        }


        return $this->sendResponse($restaurant, "success");
    }

    // -------------------store------------------------------


    public function store(Request $request)
    {

        $validated =  $this->validate($request, [
            'name' => 'required|min:2|max:150',
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
            $photo->move("images/restaurants",$name);
            $validated['photo'] = "images/restaurants/" . $name;

        }

        $restaurant = Restaurant::create($validated);
        return $this->sendResponse($restaurant, "success");
    }



    // -------------------update-------------------------------


    public function update($id, Request $request)
    {
        $restaurant  = Restaurant::find($id);

        if (!$restaurant) {
            return $this->sendError("not found");
        }






        $validated =  $this->validate($request, [
            'name' => 'required|min:2|max:150',
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
            $photo->move("images/restaurants",$name);
            $validated['photo'] = "images/restaurants/" . $name;

            $path = base_path("public") . "/" . $restaurant->photo;
            $this->deleteFile($path);
        }




        $restaurant->update($validated);

        return $this->sendResponse($restaurant, "success update");
    }


    // -----------------------delete--------------------------


    public function delete($id)
    {
        $restaurant  = Restaurant::find($id);

        if (!$restaurant) {
            return $this->sendError("not found");
        }


        $path = base_path("public") . "/" . $restaurant->photo;
        $this->deleteFile($path);

        $restaurant->delete();

        return $this->sendResponse(null, "success delete");
    }



    //
}
