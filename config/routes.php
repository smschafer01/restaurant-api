<?php

use RestaurantAPI\Controllers\RestaurantChainController;
use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {

    $app->get('/', function (Request $request, Response $response, array $args) {
        $response->getBody()->write('Welcome to Restaurant API!');
        return $response;
    });

    $app->get('/api/hello/{name}', function (Request $request, Response $response, array $args) {
        $response->getBody()->write("Hello " . $args['name']);
        return $response;
    });

    //Route group for api/v1 pattern
    $app->group('/api/v1', function(RouteCollectorProxy $group) {

        $group->group('/restaurant_chains', function(RouteCollectorProxy $group) {
            $group->get('', 'RestaurantChains:index');
            $group->get('/{chain_id}', 'RestaurantChains:view');
        });
    });

    $app->any('/{route:.*}', function (Request $request, Response $response) {
        $response->getBody()->write("Page Not Found");
        return $response->withStatus(404);
    });
};