<?php
namespace RestaurantAPI\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use RestaurantAPI\Models\MenuCategory;
use RestaurantAPI\Controllers\ControllerHelper as Helper;

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

    // DELETE /api/v1/menu_categories/{category_id}
    public function delete(Request $request, Response $response, array $args) : Response {
        $id = $args['category_id'];
        $category = MenuCategory::findOrFail($id);
        $category->delete();
        return Helper::withJson($response, ['message' => 'Menu category deleted successfully'], 200);
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
}
 
