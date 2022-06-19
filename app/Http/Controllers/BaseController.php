<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class BaseController extends Controller
{



    public function sendResponse($result, $message = "", $status = 200)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,

        ];

        return response()->json($response, $status);
    }



    // -------------------------------------------------


    public function sendError($error, $errors_messages = [], $status = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if (!empty($errors_messages)) {
            $response['errros'] = $errors_messages;
        }


        return response()->json($response, $status);
    }



    // -------------------------------------------

       // -----------------------------------------------------
       public static function deleteFile($path)
       {
           if(File::exists($path)){
               File::delete($path);
           }

           // return false;
       }


}
