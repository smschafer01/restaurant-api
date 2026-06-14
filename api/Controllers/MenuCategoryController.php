<?php
namespace RestaurantAPI\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use RestaurantAPI\Models\MenuCategory;
use RestaurantAPI\Controllers\ControllerHelper as Helper;
use RestaurantAPI\Validation\Validator;

class MenuCategoryController {

    // GET /api/v1/menu_categories
    // Returns all menu categories
    public function index(Request $request, Response $response, array $args) : Response {
        //Get querystring variables from url
        $params = $request->getQueryParams();
        $term = array_key_exists('q', $params) ? $params['q'] : "";
        //Call the model method to get menu categories
        $results = ($term) ? MenuCategory::searchMenuCategories($term) : MenuCategory::getMenuCategories();
        return Helper::withJson($response, $results, 200);
    }

    // GET /api/v1/menu_categories/{category_id}
    // Returns a single menu category by ID
    public function view(Request $request, Response $response, array $args) : Response {
        $id = $args['category_id'];
        $results = MenuCategory::getMenuCategoryById($id);
        return Helper::withJson($response, $results, 200);
    }

    //Delete a MenuCategory
    public function delete(Request $request, Response $response, array $args) : Response {
        $menuCategory = MenuCategory::deleteMenuCategory($request);
        if(!$menuCategory) {
            $results['status']= "Menu Category cannot been deleted.";
            return Helper::withJson($response, $results, 500);
        }
        $results['status'] = "Menu Category has been deleted.";
        return Helper::withJson($response, $results, 200);
    }

  public function search(Request $request, Response $response, array $args) : Response {
    $params = $request->getQueryParams();
    $q = $params['q'] ?? '';

    if (empty($q)) {
        return Helper::withJson($response, ['message' => 'Search query parameter q is required'], 400);
    }

    $keywords = explode(' ', trim($q));
    $results = MenuCategory::searchMenuCategories($keywords);
    return Helper::withJson($response, $results, 200);
}

//Create a menuCategory
    public function create(Request $request, Response $response, array $args) : Response {

        //Validate the request
        $validation = Validator::validateMenuCategory($request);
        if(!$validation) {
            $results = [
                'status' => "Validation failed",
                'errors' => Validator::getErrors()
            ];
            return Helper::withJson($response, $results, 500);
        }

        //Create a new menuCategory
        $menuCategory = MenuCategory::createMenuCategory($request);
        if(!$menuCategory) {
            $results['status']= "Menu Category cannot been created.";
            return Helper::withJson($response, $results, 500);
        }
        $results = [
            'status' => "Menu Category has been created.",
            'data' => $menuCategory
        ];
        return Helper::withJson($response, $results, 200);
    }

    //Update a menu category
    public function update(Request $request, Response $response, array $args) : Response {
        //Validate the request
        $validation = Validator::validateMenuCategory($request);
        //if validation failed
        if(!$validation) {
            $results = [
                'status' => "Validation failed",
                'errors' => Validator::getErrors()
            ];
            return Helper::withJson($response, $results, 500);
        }
        $menuCategory = MenuCategory::updateMenuCategory($request);
        if(!$menuCategory) {
            $results['status']= "Menu Category cannot been updated.";
            return Helper::withJson($response, $results, 500);
        }
        $results = [
            'status' => "Menu Category has been updated.",
            'data' => $menuCategory
        ];
        return Helper::withJson($response, $results, 200);
    }
}
 
