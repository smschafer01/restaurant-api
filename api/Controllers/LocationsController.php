<?php

namespace RestaurantAPI\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use RestaurantAPI\Models\Locations;
use RestaurantAPI\Controllers\ControllerHelper as Helper;

class LocationsController {


    public function index(Request $request, Response $response, array $args) : Response {
        $results = Locations::getLocations();
        return Helper::withJson($response, $results, 200);
    }

    public function view(Request $request, Response $response, array $args) : Response {
        $results = Locations::getLocationById($args['location_id']);
        return Helper::withJson($response, $results, 200);
    }

    public function viewAmenities(Request $request, Response $response, array $args) : Response {
        $results = Locations::getAmenitiesByLocation($args['location_id']);
        return Helper::withJson($response, $results, 200);
    }



}