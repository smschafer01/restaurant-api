<?php
namespace RestaurantAPI\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use RestaurantAPI\Models\Amenity;
use RestaurantAPI\Controllers\ControllerHelper as Helper;

class AmenityController {

    // GET /api/v1/amenities
    // Returns all amenities
    public function index(Request $request, Response $response, array $args) : Response {
        $results = Amenity::getAmenities();
        return Helper::withJson($response, $results, 200);
    }

    // GET /api/v1/amenities/{amenity_id}
    // Returns a single amenity by ID
    public function view(Request $request, Response $response, array $args) : Response {
        $id = $args['amenity_id'];
        $results = Amenity::getAmenityById($id);
        return Helper::withJson($response, $results, 200);
    }

    public function viewAmenityLocations(Request $request, Response $response, array $args) : Response {
        $amenity_id = $args['amenity_id'];
        $results = Amenity::getLocationAmenities($amenity_id);
        return Helper::withJson($response, $results, 200);
    }
}
