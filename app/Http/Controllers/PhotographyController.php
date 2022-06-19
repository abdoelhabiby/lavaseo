<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Photography;

class PhotographyController extends BaseController
{



    public function index()
    {
        $photography = Photography::get();
        return $this->sendResponse($photography);
    }

    // ------------------------------
    public function show($id)
    {
        $photography  = Photography::find($id);

        if (!$photography) {
            return $this->sendError("not found");
        }


        return $this->sendResponse($photography, "success");
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
            'package' => 'required|min:2|max:150',


        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $name = $photo->hashName();
            $photo->move("images/photography",$name);
            $validated['photo'] = "images/photography/" . $name;
        }

        $photography = Photography::create($validated);
        return $this->sendResponse($photography, "success");
    }



    // -------------------update-------------------------------


    public function update($id, Request $request)
    {
        $photography  = Photography::find($id);

        if (!$photography) {
            return $this->sendError("not found");
        }



        $validated =  $this->validate($request, [
            'name' => 'required|min:2|max:150',
            'email' => 'required|email',
            "address" => "required|min:2|max:225",
            "mobile" => "required|digits_between:5,15",
            "price" => "required|numeric",
            "photo" => "nullable|image|mimes:png,jpg,jpeg",
            "vr_video" => "nullable|string", // for now
            'package' => 'required|min:2|max:150',

        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $name = $photo->hashName();
            $photo->move("images/photography",$name);
            $validated['photo'] = "images/photography/" . $name;

            $path = base_path("public") . "/" . $photography->photo;
            $this->deleteFile($path);
        }




        $photography->update($validated);

        return $this->sendResponse($photography, "success update");
    }


    // -----------------------delete--------------------------


    public function delete($id)
    {
        $photography  = Photography::find($id);

        if (!$photography) {
            return $this->sendError("not found");
        }
        $path = base_path("public") . "/" . $photography->photo;
        $this->deleteFile($path);

        $photography->delete();

        return $this->sendResponse(null, "success delete");
    }



    //
}
