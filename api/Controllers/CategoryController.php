<?php

namespace RestaurantAPI\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use RestaurantAPI\Models\Category;
use RestaurantAPI\Controllers\ControllerHelper as Helper;

class CategoryController {

    public function index(Request $request, Response $response, array $args) : Response {
        $results = Category::getCategories();
        return Helper::withJson($response, $results, 200);
    }

    public function view(Request $request, Response $response, array $args) : Response {
        $id = $args['category_id'];
        $results = Category::getCategoryById($id);
        return Helper::withJson($response, $results, 200);
    }

    public function locations(Request $request, Response $response, array $args) : Response {
        $id = $args['category_id'];
        $category = Category::findOrFail($id);
        $results = $category->locations;
        return Helper::withJson($response, $results, 200);
    }
}
