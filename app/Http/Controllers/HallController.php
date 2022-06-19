<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Hall;

class HallController extends BaseController
{



    public function index()
    {
        $halls = Hall::get();
        return $this->sendResponse($halls);
    }

    // ------------------------------
    public function show($id)
    {
        $hall  = Hall::find($id);

        if (!$hall) {
            return $this->sendError("not found");
        }


        return $this->sendResponse($hall, "success");
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
            "photo" => "nullable|image|mimes:png,jpg,jpeg",
            "vr_video" => "nullable|string" // for now

        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $name = $photo->hashName();
            $photo->move("images/halls",$name);
            $validated['photo'] = "images/halls/" . $name;
        }

        $hall = Hall::create($validated);
        return $this->sendResponse($hall, "success");
    }



    // -------------------update-------------------------------


    public function update($id, Request $request)
    {
        $hall  = Hall::find($id);

        if (!$hall) {
            return $this->sendError("not found");
        }



        $validated =  $this->validate($request, [
            'name' => 'required|min:2|max:150',
            'email' => 'required|email',
            "address" => "required|min:2|max:225",
            "mobile" => "required|digits_between:5,15",
            "price" => "required|numeric",
            "photo" => "nullable|image|mimes:png,jpg,jpeg",
            "vr_video" => "nullable|string" // for now

        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $name = $photo->hashName();
            $photo->move("images/halls",$name);
            $validated['photo'] = "images/halls/" . $name;

            $path = base_path("public") . "/" . $hall->photo;
            $this->deleteFile($path);
        }




        $hall->update($validated);

        return $this->sendResponse($hall, "success update");
    }


    // -----------------------delete--------------------------


    public function delete($id)
    {
        $hall  = Hall::find($id);

        if (!$hall) {
            return $this->sendError("not found");
        }
        $path = base_path("public") . "/" . $hall->photo;
        $this->deleteFile($path);

        $hall->delete();

        return $this->sendResponse(null, "success delete");
    }



    //
}
