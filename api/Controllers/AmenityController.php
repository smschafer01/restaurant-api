<?php
namespace RestaurantAPI\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use RestaurantAPI\Models\Amenity;
use RestaurantAPI\Controllers\ControllerHelper as Helper;
use RestaurantAPI\Validation\Validator;

class AmenityController {


    // GET /api/v1/amenities
    // Returns all amenities with pagination + sorting
public function index(Request $request, Response $response, array $args) : Response {

    // Read query params
    $params = $request->getQueryParams();

    $page = isset($params['page']) ? max(1, intval($params['page'])) : 1;
    $perPage = isset($params['per_page']) ? max(1, intval($params['per_page'])) : 10;

    // Sorting
    $allowedSortFields = ['amenity_id', 'amenity_name', 'description', 'icon_name'];
    $sort = $params['sort'] ?? 'amenity_id';
    $order = strtolower($params['order'] ?? 'asc');

    if (!in_array($sort, $allowedSortFields)) {
        $sort = 'amenity_id';
    }

    if (!in_array($order, ['asc', 'desc'])) {
        $order = 'asc';
    }

    // Pagination offset
    $offset = ($page - 1) * $perPage;

    // Query amenities with sorting + pagination
    $results = Amenity::orderBy($sort, $order)
        ->skip($offset)
        ->take($perPage)
        ->get();

    // Total count for pagination metadata
    $total = Amenity::count();
    $totalPages = ceil($total / $perPage);

    // Response structure
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

    // GET /api/v1/amenities/{amenity_id}
    // Returns a single amenity by ID
    public function view(Request $request, Response $response, array $args) : Response {
        $id = $args['amenity_id'];
        $results = Amenity::getAmenityById($id);
        return Helper::withJson($response, $results, 200);
    }

    // GET /api/v1/amenities/{amenity_id}/locations
    // Returns all locations for an amenity
    public function viewAmenityLocations(Request $request, Response $response, array $args) : Response {
        $amenity_id = $args['amenity_id'];
        $results = Amenity::getLocationAmenities($amenity_id);
        return Helper::withJson($response, $results, 200);
    }

    // DELETE /api/v1/amenities/{amenity_id}
    // Deletes an amenity by ID
    public function delete(Request $request, Response $response, array $args) : Response {
        $id = $args['amenity_id'];
        $amenity = Amenity::findOrFail($id);
        $amenity->delete();
        return Helper::withJson($response, ['message' => 'Amenity deleted successfully'], 200);
    }

    // GET /api/v1/amenities/search?q=keyword
    // Searches amenities by amenity_name, description, or icon_name
    public function search(Request $request, Response $response, array $args) : Response {
        $params = $request->getQueryParams();
        $q = $params['q'] ?? '';

        if (empty($q)) {
            return Helper::withJson($response, ['message' => 'Search query parameter q is required'], 400);
        }

        $keywords = explode(' ', trim($q));

        $results = Amenity::where(function($query) use ($keywords) {
            foreach ($keywords as $keyword) {
                $query->orWhere('amenity_name', 'LIKE', "%{$keyword}%")
                      ->orWhere('description', 'LIKE', "%{$keyword}%")
                      ->orWhere('icon_name', 'LIKE', "%{$keyword}%");
            }
        })->get();

        return Helper::withJson($response, $results, 200);
    }

    //Create an amenity
    public function create(Request $request, Response $response, array $args) : Response {

        //Validate the request
        $validation = Validator::validateAmenity($request);
        if(!$validation) {
            $results = [
                'status' => "Validation failed",
                'errors' => Validator::getErrors()
            ];
            return Helper::withJson($response, $results, 500);
        }

        //Create a new amenity
        $amenity = Amenity::createAmenity($request);
        if(!$amenity) {
            $results['status']= "Amenity cannot been created.";
            return Helper::withJson($response, $results, 500);
        }
        $results = [
            'status' => "Amenity has been created.",
            'data' => $amenity
        ];
        return Helper::withJson($response, $results, 200);
    }

    //Update an amenity
    public function update(Request $request, Response $response, array $args) : Response {
        //Validate the request
        $validation = Validator::validateAmenity($request);
        //if validation failed
        if(!$validation) {
            $results = [
                'status' => "Validation failed",
                'errors' => Validator::getErrors()
            ];
            return Helper::withJson($response, $results, 500);
        }
        $amenity = Amenity::updateAmenity($request);
        if(!$amenity) {
            $results['status']= "Amenity cannot been updated.";
            return Helper::withJson($response, $results, 500);
        }
        $results = [
            'status' => "Amenity has been updated.",
            'data' => $amenity
        ];
        return Helper::withJson($response, $results, 200);
    }
}
