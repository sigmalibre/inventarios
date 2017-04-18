<?php

namespace Sigmalibre\Accounts\LogIn;

use Slim\Http\Request;
use Slim\Http\Response;

class LoggedInCheckMiddleware
{
    public function __invoke(Request $request, Response $response, $next)
    {
        if ($request->getRequestTarget() === '/login') {
            return $next($request, $response);
        }

        if (isset($_SESSION['uid']) === false) {
            return $response->withRedirect('/login');
        }

        $request = $request->withAttribute('isAdmin', $_SESSION['username'] === 'admin');

        return $next($request, $response);
    }
}
