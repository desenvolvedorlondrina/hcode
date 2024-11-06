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

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

/**
 * Classe que implementa o middleware AMBIENTE
 *
 * @category Middleware
 * @package  Amichi/Middleware
 * @author   Luiz Amichi <eu@luizamichi.com.br>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/luizamichi/hcode-store
 */
class EnvironmentMiddleware implements MiddlewareInterface
{
    /**
     * Verifica se a requisição é de uma rota que retorna um JSON ou um HTML
     *
     * @param Request        $request Requisição
     * @param RequestHandler $handler Manipulador da requisição
     *
     * @return Response
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $env = (string) $request->getAttribute("__route__")?->getCallable();
        $env = str_contains($env, "View");

        putenv("APPLICATION_ENVIRONMENT=" . ($env ? "view" : "api"));

        return $handler->handle($request);
    }
}
