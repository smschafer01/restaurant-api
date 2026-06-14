<?php
namespace RestaurantAPI\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use RestaurantAPI\Models\Amenity;
use RestaurantAPI\Controllers\ControllerHelper as Helper;
use RestaurantAPI\Validation\Validator;

class AmenityController {

    // GET /api/v1/amenities
    // Returns all amenities
    public function index(Request $request, Response $response, array $args) : Response {
        $results = Amenity::getAmenities($request);
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
    public function viewAmenityLocations(Request $request, Response $response, array $args) : Response {
        $amenity_id = $args['amenity_id'];
        $results = Amenity::getLocationAmenities($amenity_id);
        return Helper::withJson($response, $results, 200);
    }

    //Delete an Amenity
    public function delete(Request $request, Response $response, array $args) : Response {
        $amenity = Amenity::deleteAmenity($request);
        if(!$amenity) {
            $results['status']= "The Amenity cannot been deleted.";
            return Helper::withJson($response, $results, 500);
        }
        $results['status'] = "The Amenity has been deleted.";
        return Helper::withJson($response, $results, 200);
    }

    // GET /api/v1/amenities/search?q=keyword
    public function search(Request $request, Response $response, array $args) : Response {
    $params = $request->getQueryParams();
    $q = $params['q'] ?? '';

    if (empty($q)) {
        return Helper::withJson($response, ['message' => 'Search query parameter q is required'], 400);
    }

    $keywords = explode(' ', trim($q));
    $results = Amenity::searchAmenities($keywords);
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
