<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Wedding;

class WeddingController extends BaseController
{



    public function index()
    {

        $wedding = Wedding::get();
        return $this->sendResponse($wedding);
    }

    // ------------------------------
    public function show($id)
    {
        $wedding  = Wedding::find($id);

        if (!$wedding) {
            return $this->sendError("not found");
        }


        return $this->sendResponse($wedding, "success");
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
            $photo->move("images/wedding", $name);
            $validated['photo'] = "images/wedding/" . $name;
        }

        $wedding = Wedding::create($validated);
        return $this->sendResponse($wedding, "success");
    }



    // -------------------update-------------------------------


    public function update($id, Request $request)
    {
        $wedding  = Wedding::find($id);

        if (!$wedding) {
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
            $photo->move("images/wedding", $name);
            $validated['photo'] = "images/wedding/" . $name;

            $path = base_path("public") . "/" . $wedding->photo;
            $this->deleteFile($path);
        }




        $wedding->update($validated);

        return $this->sendResponse($wedding, "success update");
    }


    // -----------------------delete--------------------------


    public function delete($id)
    {
        $wedding  = Wedding::find($id);

        if (!$wedding) {
            return $this->sendError("not found");
        }

        $path = base_path("public") . "/" . $wedding->photo;
        $this->deleteFile($path);

        $wedding->delete();
        return $this->sendResponse(null, "success delete");

    }



    //
}
