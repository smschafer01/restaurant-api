<?php

namespace RestaurantAPI\Authentication;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use RestaurantAPI\Models\User;

class MyAuthenticator
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        if (!$request->hasHeader('RestaurantAPI-Authorization')) {
            $results = ['Status' => 'RestaurantAPI-Authorization header not found.'];
            return AuthenticationHelper::withJson($results, 401);
        }

        $auth = $request->getHeader('RestaurantAPI-Authorization');
        list($username, $password) = explode(':', $auth[0]);

        if (!User::authenticateUser($username, $password)) {
            $results = ['Status' => 'Authentication failed.'];
            return AuthenticationHelper::withJson($results, 403);
        }

        return $handler->handle($request);
    }
}
