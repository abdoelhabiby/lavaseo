<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Hairdresser;

class HairdresserController extends BaseController
{



    public function index()
    {
        $hairdresser = Hairdresser::get();
        return $this->sendResponse($hairdresser);
    }

    // ------------------------------
    public function show($id)
    {
        $hairdresser  = Hairdresser::find($id);

        if (!$hairdresser) {
            return $this->sendError("not found");
        }


        return $this->sendResponse($hairdresser, "success");
    }

    // -------------------store------------------------------


    public function store(Request $request)
    {

        $validated =  $this->validate($request, [
            'name' => 'required|min:2|max:150',
            'type' => 'required|min:2|max:150',
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
            $photo->move("images/hairdresser", $name);
            $validated['photo'] = "images/hairdresser/" . $name;
        }

        $hairdresser = Hairdresser::create($validated);
        return $this->sendResponse($hairdresser, "success");
    }



    // -------------------update-------------------------------


    public function update($id, Request $request)
    {
        $hairdresser  = Hairdresser::find($id);

        if (!$hairdresser) {
            return $this->sendError("not found");
        }



        $validated =  $this->validate($request, [
            'name' => 'required|min:2|max:150',
            'type' => 'required|min:2|max:150',
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
            $photo->move("images/hairdresser", $name);
            $validated['photo'] = "images/hairdresser/" . $name;

            $path = base_path("public") . "/" . $hairdresser->photo;
            $this->deleteFile($path);
        }




        $hairdresser->update($validated);

        return $this->sendResponse($hairdresser, "success update");
    }


    // -----------------------delete--------------------------


    public function delete($id)
    {
        $hairdresser  = Hairdresser::find($id);

        if (!$hairdresser) {
            return $this->sendError("not found");
        }

        $path = base_path("public") . "/" . $hairdresser->photo;
        $this->deleteFile($path);

        $hairdresser->delete();

        return $this->sendResponse(null, "success delete");
    }



    //
}
