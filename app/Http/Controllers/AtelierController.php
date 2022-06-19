<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AteAtelier;
use Illuminate\Validation\Rule;
use App\Http\Controllers\BaseController;
use App\Models\Atelier;

class AtelierController extends BaseController
{



    public function index()
    {
        $atelier = Atelier::get();
        return $this->sendResponse($atelier);
    }

        // ------------------------------
        public function show($id)
        {

            $atelier  = Atelier::find($id);

            if (!$atelier) {
                return $this->sendError("not found");
            }

            return $this->sendResponse($atelier, "success");
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

        if($request->hasFile('photo'))
        {
            $photo = $request->file('photo');
            $name = $photo->hashName();
            $photo->move("images/atelier",$name);
            $validated['photo']= "images/atelier/" . $name;



        }

        $atelier = Atelier::create($validated);
        return $this->sendResponse($atelier, "success");

    }



    // -------------------update-------------------------------


    public function update($id, Request $request)
    {
        $atelier  = Atelier::find($id);

        if (!$atelier) {
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

        if($request->hasFile('photo'))
        {
            $photo = $request->file('photo');
            $name = $photo->hashName();
            $photo->move("images/atelier",$name);
            $validated['photo']= "images/atelier/" . $name;

            $path = base_path("public") . "/" . $atelier->photo;
            $this->deleteFile($path);

        }




        $atelier->update($validated);

        return $this->sendResponse($atelier, "success update");
    }


    // -----------------------delete--------------------------


    public function delete($id)
    {
        $atelier  = Atelier::find($id);

        if (!$atelier) {
            return $this->sendError("not found");
        }

        $path = base_path("public") . "/" . $atelier->photo;
        $this->deleteFile($path);

        $atelier->delete();

        return $this->sendResponse(null, "success delete");
    }



    //
}
