<?php

namespace RestaurantAPI\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use RestaurantAPI\Models\Locations;
use RestaurantAPI\Controllers\ControllerHelper as Helper;

class LocationsController {

    public function index(Request $request, Response $response, array $args) : Response {

        $params = $request->getQueryParams();

        $page = isset($params['page']) ? max(1, intval($params['page'])) : 1;
        $perPage = isset($params['per_page']) ? max(1, intval($params['per_page'])) : 10;

        $allowedSortFields = ['location_id', 'location_name', 'address', 'city', 'state'];
        $sort = $params['sort'] ?? 'location_id';
        $order = strtolower($params['order'] ?? 'asc');

        if (!in_array($sort, $allowedSortFields)) {
            $sort = 'location_id';
        }

        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'asc';
        }

        $offset = ($page - 1) * $perPage;

        $results = Locations::orderBy($sort, $order)
            ->skip($offset)
            ->take($perPage)
            ->get();

        $total = Locations::count();
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

    public function view(Request $request, Response $response, array $args) : Response {
        $results = Locations::getLocationById($args['location_id']);
        return Helper::withJson($response, $results, 200);
    }

    public function viewAmenities(Request $request, Response $response, array $args) : Response {
        $results = Locations::getAmenitiesByLocation($args['location_id']);
        return Helper::withJson($response, $results, 200);
    }
}
