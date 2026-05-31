<?php

namespace RestaurantAPI\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use RestaurantAPI\Models\Location;
use RestaurantAPI\Controllers\ControllerHelper as Helper;

class LocationController {

    // GET /api/v1/locations
    public function index(Request $request, Response $response, array $args) : Response {
        $results = Location::with('chains')->get();
        return Helper::withJson($response, $results, 200);
    }

    // GET /api/v1/locations/{location_id}
    public function view(Request $request, Response $response, array $args) : Response {
        $id = $args['location_id'];

        $results = Location::with('chains')
            ->findOrFail($id);

        return Helper::withJson($response, $results, 200);
    }

    // FIXED: GET locations that have a specific chain
    public function byChain(Request $request, Response $response, array $args) : Response {
        $chain_id = $args['chain_id'];

        $results = Location::whereHas('chains', function ($query) use ($chain_id) {
            $query->where('chain_id', $chain_id);
        })->get();

        return Helper::withJson($response, $results, 200);
    }

    // GET /api/v1/locations/{location_id}/categories
    public function categories(Request $request, Response $response, array $args) : Response {
        $id = $args['location_id'];

        $location = Location::findOrFail($id);
        $results = $location->categories;

        return Helper::withJson($response, $results, 200);
    }
}