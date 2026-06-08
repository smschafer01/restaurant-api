<?php

namespace RestaurantAPI\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use RestaurantAPI\Models\RestaurantChains;
use RestaurantAPI\Controllers\ControllerHelper as Helper;

class RestaurantChainController {

   public function index(Request $request, Response $response, array $args) : Response {

    $params = $request->getQueryParams();

    $page = isset($params['page']) ? max(1, intval($params['page'])) : 1;
    $perPage = isset($params['per_page']) ? max(1, intval($params['per_page'])) : 10;

    $allowedSortFields = ['chain_id', 'chain_name', 'description'];
    $sort = $params['sort'] ?? 'chain_id';
    $order = strtolower($params['order'] ?? 'asc');

    if (!in_array($sort, $allowedSortFields)) {
        $sort = 'chain_id';
    }

    if (!in_array($order, ['asc', 'desc'])) {
        $order = 'asc';
    }

    $offset = ($page - 1) * $perPage;

    $results = RestaurantChains::orderBy($sort, $order)
        ->skip($offset)
        ->take($perPage)
        ->get();

    $total = RestaurantChains::count();
    $totalPages = ceil($total / $perPage);

    $payload = [
        'data' => $results,
        'pagination' => [
            'page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'total_pages' => $totalPages
        ]
    ];

    return Helper::withJson($response, $payload, 200);
}


    //view a specific restaurant chain
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