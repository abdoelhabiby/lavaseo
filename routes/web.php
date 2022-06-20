<?php

use Illuminate\Support\Facades\File;

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/



$default_routes_controllers_schema = [

    ["route_name" => "adminstrations", "controller" => "AdministrationController"],
    ["route_name" => "atelier",  "controller" => "AtelierController"],
    ["route_name" => "cafe",  "controller" => "CafeController"],
    ["route_name" => "play-lists",  "controller" => "PlayListController"],
    ["route_name" => "reservations",  "controller" => "ReservationController"],
    ["route_name" => "restaurants",  "controller" => "RestaurantController"],
    ["route_name" => "wedding",  "controller" => "WeddingController"],
    ["route_name" => "clubs",  "controller" => "ClubController"],
    ["route_name" => "halls",  "controller" => "HallController"],
    ["route_name" => "hotels",  "controller" => "HotelsController"],
    ["route_name" => "photography",  "controller" => "PhotographyController"],
    ["route_name" => "hairdresser",  "controller" => "HairdresserController"],
    ["route_name" => "car",  "controller" => "CarController"],
    ["route_name" => "clients",  "controller" => "ClientController"],



];





foreach ($default_routes_controllers_schema as $routes_schema) {

    $name =  $routes_schema['route_name'];
    $controller =  $routes_schema['controller'];

    $router->get("$name", "$controller@index");
    $router->get("$name/{id}", "$controller@show");
    $router->post("$name", "$controller@store");
    $router->post("$name/{id}", "$controller@update");
    $router->post("$name/{id}/delete", "$controller@delete");

}



$router->get('/', function () use ($router) {

    return response("Hala Madrid Aporla 14 :)");
});
