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
        $results = MenuCategory::getMenuCategories();
        return Helper::withJson($response, $results, 200);
    }

    // GET /api/v1/menu_categories/{category_id}
    // Returns a single menu category by ID
    public function view(Request $request, Response $response, array $args) : Response {
        $id = $args['category_id'];
        $results = MenuCategory::getMenuCategoryById($id);
        return Helper::withJson($response, $results, 200);
    }
}
