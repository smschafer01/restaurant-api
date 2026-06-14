<?php

namespace RestaurantAPI\Authentication;

use Psr\Http\Message\ResponseInterface as Response;

class AuthenticationHelper
{
    public static function withJson($data, $status = 200)
    {
        $response = new \Slim\Psr7\Response();
        $response->getBody()->write(json_encode($data));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }
}
