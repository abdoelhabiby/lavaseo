<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Club;

class ClubController extends BaseController
{



    public function index()
    {
        $club = Club::get();
        return $this->sendResponse($club);
    }

    // ------------------------------
    public function show($id)
    {
        $club  = Club::find($id);

        if (!$club) {
            return $this->sendError("not found");
        }


        return $this->sendResponse($club, "success");
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
            $photo->move("images/clubs",$name);
            $validated['photo'] = "images/clubs/" . $name;
        }

        $club = Club::create($validated);
        return $this->sendResponse($club, "success");
    }



    // -------------------update-------------------------------


    public function update($id, Request $request)
    {
        $club  = Club::find($id);

        if (!$club) {
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
            $photo->move("images/clubs",$name);
            $validated['photo'] = "images/clubs/" . $name;

            $path = base_path("public") . "/" . $club->photo;
            $this->deleteFile($path);
        }




        $club->update($validated);

        return $this->sendResponse($club, "success update");
    }


    // -----------------------delete--------------------------


    public function delete($id)
    {
        $club  = Club::find($id);

        if (!$club) {
            return $this->sendError("not found");
        }

        $path = base_path("public") . "/" . $club->photo;
        $this->deleteFile($path);

        $club->delete();

        return $this->sendResponse(null, "success delete");
    }



    //
}
