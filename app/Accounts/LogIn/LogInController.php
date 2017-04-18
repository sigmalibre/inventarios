<?php

namespace Sigmalibre\Accounts\LogIn;

use Sigmalibre\Accounts\DataSource\CreateUser;
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

        $usuarioID = $lista_usuarios[0]['UsuarioID'] ?? false;
        $usuario = $lista_usuarios[0]['Username'] ?? false;
        $password = $lista_usuarios[0]['Password'] ?? false;

        if ($usuario !== $params['user']) {
            return $response->withRedirect('/login?failed=1');
        }

        if (password_verify($params['pass'], $password) === false) {
            return $response->withRedirect('/login?failed=1');
        }

        $_SESSION['uid'] = $usuarioID;
        $_SESSION['username'] = $usuario;

        return $response->withRedirect('/');
    }

    public function newUser(Request $request, Response $response)
    {
        if ($request->getAttribute('isAdmin') !== true) {
            return $response->withRedirect('/');
        }

        $params = $request->getParsedBody();

        if (empty($params['username']) || empty($params['password'])) {
            return $response->withRedirect('/ajustes/saved=0');
        }

        $saver = new CreateUser($this->container);

        $isSaved = $saver->write([
            'username' => $params['username'],
            'password' => password_hash($params['password'], PASSWORD_DEFAULT),
        ]);

        if ($isSaved !== true) {
            return $response->withRedirect('/ajustes?saved=0');
        }

        return $response->withRedirect('/ajustes?saved=1');
    }
}
