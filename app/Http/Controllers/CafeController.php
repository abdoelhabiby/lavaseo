<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Cafe;

class CafeController extends BaseController
{



    public function index()
    {
        $cafe = Cafe::get();
        return $this->sendResponse($cafe);
    }

    // ------------------------------
    public function show($id)
    {
        $cafe  = Cafe::find($id);

        if (!$cafe) {
            return $this->sendError("not found");
        }


        return $this->sendResponse($cafe, "success");
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
            $photo->move("images/cafe",$name);
            $validated['photo'] = "images/cafe/" . $name;
        }

        $cafe = Cafe::create($validated);
        return $this->sendResponse($cafe, "success");
    }



    // -------------------update-------------------------------


    public function update($id, Request $request)
    {
        $cafe  = Cafe::find($id);

        if (!$cafe) {
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
            $photo->move("images/cafe",$name);
            $validated['photo'] = "images/cafe/" . $name;

            $path = base_path("public") . "/" . $cafe->photo;
            $this->deleteFile($path);
        }




        $cafe->update($validated);

        return $this->sendResponse($cafe, "success update");
    }


    // -----------------------delete--------------------------


    public function delete($id)
    {
        $cafe  = Cafe::find($id);

        if (!$cafe) {
            return $this->sendError("not found");
        }

        $path = base_path("public") . "/" . $cafe->photo;
        $this->deleteFile($path);

        $cafe->delete();

        return $this->sendResponse(null, "success delete");
    }



    //
}
