<?php
use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {

    $app->get('/', function (Request $request, Response $response, array $args) {
        $response->getBody()->write('Welcome to Restaurant API!');
        return $response;
    });

    $app->group('/api/v1', function(RouteCollectorProxy $group) {

        // Restaurant chains routes (Member 1)
        $group->group('/restaurant_chains', function(RouteCollectorProxy $group) {
            $group->get('', 'RestaurantChains:index');
            $group->get('/{chain_id}', 'RestaurantChains:view');
            $group->get('/{chain_id}/locations', 'RestaurantChains:viewLocations');
        });

        // Menu categories routes (Member 2)
        $group->group('/menu_categories', function(RouteCollectorProxy $group) {
            $group->get('', 'MenuCategory:index');
            $group->get('/search', 'MenuCategory:search');
            $group->get('/{category_id}', 'MenuCategory:view');
            $group->delete('/{id}', 'MenuCategory:delete');
            $group->post('', 'MenuCategory:create');
            $group->put('/{id}', 'MenuCategory:update');

        });

        // Amenities routes (Member 2)
        $group->group('/amenities', function(RouteCollectorProxy $group) {
            $group->get('', 'Amenity:index');
            $group->get('/search', 'Amenity:search');
            $group->get('/{amenity_id}', 'Amenity:view');
            $group->get('/{amenity_id}/locations', 'Amenity:viewAmenityLocations');
            $group->delete('/{id}', 'Amenity:delete');
            $group->post('', 'Amenity:create');
            $group->put('/{id}', 'Amenity:update');

        });

        // Locations routes
        $group->group('/locations', function(RouteCollectorProxy $group) {
            $group->get('', 'Locations:index');
            $group->get('/{location_id}', 'Locations:view');
            $group->get('/{location_id}/amenities', 'Locations:viewAmenities');
        });

    });

    $app->any('/{route:.*}', function (Request $request, Response $response) {
        $response->getBody()->write("Page Not Found");
        return $response->withStatus(404);
    });
};
