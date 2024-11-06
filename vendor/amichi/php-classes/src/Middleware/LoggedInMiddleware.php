<?php

/**
 * PHP version 8.3.12
 *
 * @category Middleware
 * @package  Amichi/Middleware
 * @author   Luiz Amichi <eu@luizamichi.com.br>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/luizamichi/hcode-store
 */

namespace Amichi\Middleware;

use Amichi\HttpException;
use Amichi\Model\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

/**
 * Classe que implementa o middleware USUÁRIO CONECTADO
 *
 * @category Middleware
 * @package  Amichi/Middleware
 * @author   Luiz Amichi <eu@luizamichi.com.br>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/luizamichi/hcode-store
 */
class LoggedInMiddleware
{
    /**
     * Valida se o usuário está autenticado
     *
     * @param Request        $request Requisição
     * @param RequestHandler $handler Manipulador da requisição
     *
     * @return Response
     */
    public static function user(Request $request, RequestHandler $handler): Response
    {
        $user = User::loadFromSession();

        if ($user) {
            return $handler->handle($request);
        }

        throw new HttpException("Usuário não está logado.", 403);
    }


    /**
     * Valida se o usuário é um administrador e está autenticado
     *
     * @param Request        $request Requisição
     * @param RequestHandler $handler Manipulador da requisição
     *
     * @return Response
     */
    public static function admin(Request $request, RequestHandler $handler): Response
    {
        $user = User::loadFromSession();

        if ($user && $user->isAdmin) {
            return $handler->handle($request);
        }

        throw new HttpException("Administrador não está logado.", 403);
    }


    /**
     * Valida se o usuário não está autenticado
     *
     * @param Request        $request Requisição
     * @param RequestHandler $handler Manipulador da requisição
     *
     * @return Response
     */
    public static function notLogged(Request $request, RequestHandler $handler): Response
    {
        $user = User::loadFromSession();

        if (!$user) {
            return $handler->handle($request);
        }

        return $handler->handle($request)->withHeader("Location", "/admin")->withStatus(302);
    }
}
