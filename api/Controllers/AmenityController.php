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
}
