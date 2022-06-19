<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administration;
use Illuminate\Validation\Rule;
use App\Http\Controllers\BaseController;

class AdministrationController extends BaseController
{


    public function index()
    {
        $administrations =  Administration::select([
            "id", "name", "email", "mobile", "address", "created_at"
        ])->get();

        return $this->sendResponse($administrations);
    }


    // ------------------------------
    public function show($id)
    {

        $adminstration  = Administration::find($id);

        if (!$adminstration) {
            return $this->sendError("not found");
        }

        return $this->sendResponse($adminstration, "success");
    }


    // -------------------store------------------------------


    public function store(Request $request)
    {

        $validated =  $this->validate($request, [
            'name' => 'required|min:2|max:150',
            'email' => 'required|email|unique:administration,email',
            "address" => "required|min:2|max:225",
            "mobile" => "required|digits_between:5,15",
        ]);

        $adminstration = Administration::create($validated);
        return $this->sendResponse($adminstration, "success");
    }



    // -------------------update-------------------------------


    public function update($id, Request $request)
    {
        $adminstration  = Administration::find($id);

        if (!$adminstration) {
            return $this->sendError("not found");
        }



        $validated =  $this->validate($request, [
            'name' => 'required|min:2|max:150',
            'email' => 'required|email|' . Rule::unique('administration')->ignore($adminstration->id),
            "address" => "required|min:2|max:225",
            "mobile" => "required|digits_between:5,15",
        ]);



        $adminstration->update($validated);

        return $this->sendResponse($adminstration, "success update");
    }


    // -----------------------delete--------------------------


    public function delete($id)
    {
        $adminstration  = Administration::find($id);

        if (!$adminstration) {
            return $this->sendError("not found");
        }


        $adminstration->delete();

        return $this->sendResponse(null, "success delete");
    }



    //
}
