<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\PlayList;

class PlayListController extends BaseController
{



    public function index()
    {
        $playlists = PlayList::get();
        return $this->sendResponse($playlists);
    }

    // ------------------------------
    public function show($id)
    {
        $playlist  = PlayList::find($id);

        if (!$playlist) {
            return $this->sendError("not found");
        }


        return $this->sendResponse($playlist, "success");
    }

    // -------------------store------------------------------


    public function store(Request $request)
    {



        $validated =  $this->validate($request, [
            'song_name' => 'required|min:2|max:150',
            'type' => 'required|min:2|max:150',
            'language' => 'required|min:2|max:150',
            'artist_name' => 'required|min:2|max:150',
            'order' => 'required|min:2|max:150',
            "video" => "nullable|string" // for now

        ]);


        $playlist = PlayList::create($validated);
        return $this->sendResponse($playlist, "success");
    }



    // -------------------update-------------------------------


    public function update($id, Request $request)
    {
        $playlist  = PlayList::find($id);

        if (!$playlist) {
            return $this->sendError("not found");
        }



        $validated =  $this->validate($request, [
            'song_name' => 'required|min:2|max:150',
            'type' => 'required|min:2|max:150',
            'language' => 'required|min:2|max:150',
            'artist_name' => 'required|min:2|max:150',
            'order' => 'required|min:2|max:150',
            "video" => "nullable|string" // for now

        ]);


        $playlist->update($validated);

        return $this->sendResponse($playlist, "success update");
    }


    // -----------------------delete--------------------------


    public function delete($id)
    {
        $playlist  = PlayList::find($id);

        if (!$playlist) {
            return $this->sendError("not found");
        }


        $playlist->delete();

        return $this->sendResponse(null, "success delete");
    }



    //
}
