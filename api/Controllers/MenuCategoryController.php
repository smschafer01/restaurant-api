<?php
namespace RestaurantAPI\Controllers;
 
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use RestaurantAPI\Models\MenuCategory;
use RestaurantAPI\Controllers\ControllerHelper as Helper;
use RestaurantAPI\Validation\Validator;
 
class MenuCategoryController {
 
    public function index(Request $request, Response $response, array $args) : Response {

    $params = $request->getQueryParams();

    $page = isset($params['page']) ? max(1, intval($params['page'])) : 1;
    $perPage = isset($params['per_page']) ? max(1, intval($params['per_page'])) : 10;

    $allowedSortFields = ['category_id', 'category_name', 'description'];
    $sort = $params['sort'] ?? 'category_id';
    $order = strtolower($params['order'] ?? 'asc');

    if (!in_array($sort, $allowedSortFields)) {
        $sort = 'category_id';
    }

    if (!in_array($order, ['asc', 'desc'])) {
        $order = 'asc';
    }

    $offset = ($page - 1) * $perPage;

    $results = MenuCategory::orderBy($sort, $order)
        ->skip($offset)
        ->take($perPage)
        ->get();

    $total = MenuCategory::count();
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

 
    // GET /api/v1/menu_categories/{category_id}
    // Returns a single menu category by ID
    public function view(Request $request, Response $response, array $args) : Response {
        $id = $args['category_id'];
        $results = MenuCategory::getMenuCategoryById($id);
        return Helper::withJson($response, $results, 200);
    }
 
    // DELETE /api/v1/menu_categories/{category_id}
    // Deletes a menu category by ID
    public function delete(Request $request, Response $response, array $args) : Response {
        $id = $args['category_id'];
        $category = MenuCategory::findOrFail($id);
        $category->delete();
        return Helper::withJson($response, ['message' => 'Menu category deleted successfully'], 200);
    }
 
    // GET /api/v1/menu_categories/search?q=keyword
    // Searches menu categories by category_name or description
    public function search(Request $request, Response $response, array $args) : Response {
        $params = $request->getQueryParams();
        $q = $params['q'] ?? '';
 
        if (empty($q)) {
            return Helper::withJson($response, ['message' => 'Search query parameter q is required'], 400);
        }
 
        $keywords = explode(' ', trim($q));
 
        $results = MenuCategory::where(function($query) use ($keywords) {
            foreach ($keywords as $keyword) {
                $query->orWhere('category_name', 'LIKE', "%{$keyword}%")
                      ->orWhere('description', 'LIKE', "%{$keyword}%");
            }
        })->get();
 
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
 
