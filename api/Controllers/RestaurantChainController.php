<?php

namespace RestaurantAPI\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use RestaurantAPI\Models\RestaurantChains;
use RestaurantAPI\Controllers\ControllerHelper as Helper;

class RestaurantChainController {

    //list all restaurant chains
    public function index(Request $request, Response $response, array $args) : Response {
        $results = RestaurantChains::getRestaurantChains();

        return Helper::withJson($response, $results, 200);
    }

    //view a specific professor
    public function view(Request $request, Response $response, array $args) : Response {
        $chain_id = $args['chain_id'];
        $results = RestaurantChains::getRestaurantChainById($chain_id);

        return Helper::withJson($response, $results, 200);
    }

    public function viewLocations(Request $request, Response $response, array $args) : Response {
        $chain_id = $args['chain_id'];
        $results = RestaurantChains::getRestaurantChainById($chain_id);
        return Helper::withJson($response, $results, 200);
    }
}