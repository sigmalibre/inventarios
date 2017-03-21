<?php

namespace Sigmalibre\Accounts\LogIn;

use Sigmalibre\Accounts\DataSource\GetUsers;
use Slim\Http\Request;
use Slim\Http\Response;

class LogInController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function index(Request $request, Response $response)
    {
        session_destroy();
        return $this->container->view->render($response, 'auth/login.twig');
    }

    public function iniciarSesion(Request $request, Response $response)
    {
        if (isset($_SESSION['uid'])) {
            return $response->withRedirect('/login?failed=1');
        }

        $params = $request->getParsedBody();

        if (empty($params['user']) || empty($params['pass'])) {
            return $response->withRedirect('/login?failed=1');
        }

        $lista_usuarios = (new GetUsers($this->container))->read([
            'input' => [
                'user' => $params['user'],
            ],
        ]);

        if (empty($lista_usuarios)) {
            return $response->withRedirect('/login?failed=1');
        }

        $empleadoID = $lista_usuarios[0]['EmpleadoID'] ?? false;
        $usuario = $lista_usuarios[0]['Username'] ?? false;
        $password = $lista_usuarios[0]['Password'] ?? false;

        if ($usuario !== $params['user']) {
            return $response->withRedirect('/login?failed=1');
        }

        if (password_verify($params['pass'], $password) === false) {
            return $response->withRedirect('/login?failed=1');
        }

        $_SESSION['uid'] = $empleadoID;

        return $response->withRedirect('/');
    }
}
