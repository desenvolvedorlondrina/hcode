<?php

/**
 * PHP version 8.3.12
 *
 * @category Controller
 * @package  Amichi/Controller
 * @author   Luiz Amichi <eu@luizamichi.com.br>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/luizamichi/hcode-store
 */

namespace Amichi\Controller;

use Amichi\Controller;
use Amichi\HttpException;
use Amichi\Model\Address;
use Amichi\Model\Cart;
use Amichi\Model\Order;
use Amichi\Model\User;
use Amichi\Model\UserLog;
use Amichi\Model\UserPasswordRecovery;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Classe que controla a entidade USUÁRIO
 *
 * @category Controller
 * @package  Amichi/Controller
 * @author   Luiz Amichi <eu@luizamichi.com.br>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/luizamichi/hcode-store
 */
class UserController extends Controller
{
    /**
     * Retorna todos os usuários do banco de dados
     *
     * @param Request             $request  Requisição
     * @param Response            $response Resposta
     * @param array<string,mixed> $args     Argumentos da URL
     *
     * @static
     *
     * @return Response
     */
    public static function getAll(Request $request, Response $response, array $args): Response
    {
        $params = $request->getQueryParams();
        $response->getBody()->write(
            json_encode(
                array_map(
                    fn (User $user): array => $user->array(),
                    User::listAll(
                        self::int($params["_limit"]),
                        self::int($params["_offset"]),
                        self::string($params["_sortBy"])
                    )
                )
            )
        );

        return $response;
    }


    /**
     * Retorna o usuário a partir do ID informado na URL
     *
     * @param Request             $request  Requisição
     * @param Response            $response Resposta
     * @param array<string,mixed> $args     Argumentos da URL
     *
     * @static
     *
     * @return Response
     */
    public static function get(Request $request, Response $response, array $args): Response
    {
        $user = User::loadFromId(self::int($args["idUser"], true, "idUser"));
        $response->getBody()->write(json_encode($user));

        return $response->withStatus($user ? 200 : 204);
    }


    /**
     * Retorna os logs do usuário a partir do ID informado na URL
     *
     * @param Request             $request  Requisição
     * @param Response            $response Resposta
     * @param array<string,mixed> $args     Argumentos da URL
     *
     * @static
     *
     * @return Response
     */
    public static function getLogs(Request $request, Response $response, array $args): Response
    {
        $id = self::int($args["idUser"], true, "idUser");

        $sessionUser = User::loadFromSession();
        if ($sessionUser->id !== $id && !$sessionUser->isAdmin) {
            throw new HttpException("Não foi possível consultar os logs do usuário $id, pois, você não possui permissão.", 400);
        }

        $userLogs = array_map(
            fn (UserLog $userLog): array => $userLog->array(),
            UserLog::listFromUserId($id)
        );

        $response->getBody()->write(json_encode($userLogs));

        return $response;
    }


    /**
     * Retorna as recuperações de senha do usuário a partir do ID informado na URL
     *
     * @param Request             $request  Requisição
     * @param Response            $response Resposta
     * @param array<string,mixed> $args     Argumentos da URL
     *
     * @static
     *
     * @return Response
     */
    public static function getPasswordRecoveries(Request $request, Response $response, array $args): Response
    {
        $id = self::int($args["idUser"], true, "idUser");

        $sessionUser = User::loadFromSession();
        if ($sessionUser->id !== $id && !$sessionUser->isAdmin) {
            throw new HttpException("Não foi possível consultar as recuperações de senha do usuário $id, pois, você não possui permissão.", 400);
        }

        $userPasswordRecoveries = array_map(
            fn (UserPasswordRecovery $userPasswordRecovery): array => $userPasswordRecovery->array(),
            UserPasswordRecovery::listFromUserId($id)
        );

        $response->getBody()->write(json_encode($userPasswordRecoveries));

        return $response;
    }


    /**
     * Salva o usuário informado no corpo da requisição no banco de dados
     *
     * @param Request             $request  Requisição
     * @param Response            $response Resposta
     * @param array<string,mixed> $args     Argumentos da URL
     *
     * @static
     *
     * @return Response
     */
    public static function post(Request $request, Response $response, array $args): Response
    {
        $errors = [];
        $files = (array) $request->getUploadedFiles();

        $body = [
            ...(array) $request->getParsedBody(),
            "photo" => (
                isset($files["photo"]) && $files["photo"]->getError() === UPLOAD_ERR_OK &&
                $files["photo"]->getSize() <= 16777215 &&
                in_array($files["photo"]->getClientMediaType(), ["image/jpeg", "image/png"])
                    ? (string) $files["photo"]->getStream()->getContents()
                    : null
            ),
        ];

        $user = User::loadFromData($body);

        $sessionUser = User::loadFromSession();
        if (!$sessionUser || !$sessionUser->isAdmin) {
            $user->isAdmin = false;
            $user->login = (string) $user->email;
        }

        $user->validate($errors);

        if ($errors) {
            $message = count($errors) === 1 ? "O seguinte erro foi encontrado" : "Os seguintes erros foram encontrados";
            throw new HttpException("Não foi possível cadastrar o usuário. $message: " . implode(", ", $errors) . ".", 400);
        }

        $response->getBody()->write(json_encode($user->create()));

        return $response->withStatus(201);
    }


    /**
     * Altera os dados do usuário informado no corpo da requisição a partir do ID informado na URL
     *
     * @param Request             $request  Requisição
     * @param Response            $response Resposta
     * @param array<string,mixed> $args     Argumentos da URL
     *
     * @static
     *
     * @return Response
     */
    public static function put(Request $request, Response $response, array $args): Response
    {
        $errors = [];
        $id = self::int($args["idUser"], true, "idUser");

        $userDB = User::loadFromId($id);
        if (!$userDB) {
            throw new HttpException("Não foi possível alterar o usuário $id, pois, é inexistente.", 400);
        }

        $user = User::loadFromData((array) $request->getParsedBody());
        $user->id = $id;
        $user->idPerson = $userDB->idPerson;
        $user->password = $userDB->password;

        $sessionUser = User::loadFromSession();
        $enableLog = false;

        if (!$sessionUser || !$sessionUser->isAdmin) {
            $user->isAdmin = false;
            $user->login = $user->email;

            $enableLog = true;
        }

        if ($sessionUser->id !== $id && !$sessionUser->isAdmin) {
            throw new HttpException("Não foi possível alterar o usuário $id, pois, você não possui permissão.", 400);
        }

        $user->validate($errors);

        if ($errors) {
            $message = count($errors) === 1 ? "O seguinte erro foi encontrado" : "Os seguintes erros foram encontrados";
            throw new HttpException("Não foi possível alterar o usuário $id. $message: " . implode(", ", $errors) . ".", 400);
        }

        if ($enableLog) {
            $userLog = UserLog::loadFromSession();
            $userLog->description = "Data update";
            $userLog->save();
        }

        $response->getBody()->write(json_encode($user->update()));

        return $response->withStatus(200);
    }


    /**
     * Altera a senha do usuário informada no corpo da requisição a partir do ID informado na URL
     *
     * @param Request             $request  Requisição
     * @param Response            $response Resposta
     * @param array<string,mixed> $args     Argumentos da URL
     *
     * @static
     *
     * @return Response
     */
    public static function updatePassword(Request $request, Response $response, array $args): Response
    {
        $errors = [];
        $data = (array) $request->getParsedBody();
        $id = self::int($args["idUser"], true, "idUser");

        $user = User::loadFromId($id);
        if (!$user) {
            throw new HttpException("Não foi possível alterar a senha do usuário $id, pois, é inexistente.", 400);
        }

        $user->password = $data["password"] ?? "";
        $user->validate($errors);

        if ($errors) {
            $message = count($errors) === 1 ? "O seguinte erro foi encontrado" : "Os seguintes erros foram encontrados";
            throw new HttpException("Não foi possível alterar a senha do usuário $id. $message: " . implode(", ", $errors) . ".", 400);
        }

        $response->getBody()->write(json_encode($user->updatePassword($user->password)));

        return $response->withStatus(200);
    }


    /**
     * Remove o usuário a partir do ID informado na URL
     *
     * @param Request             $request  Requisição
     * @param Response            $response Resposta
     * @param array<string,mixed> $args     Argumentos da URL
     *
     * @static
     *
     * @return Response
     */
    public static function delete(Request $request, Response $response, array $args): Response
    {
        $id = self::int($args["idUser"], true, "idUser");

        $user = User::loadFromId($id);
        if (!$user) {
            throw new HttpException("Não foi possível remover o usuário $id, pois, é inexistente.", 400);
        }

        $address = Address::loadFromUserId($id);
        if ($address) {
            throw new HttpException("Não foi possível remover o usuário $id, pois, está vinculado ao endereço {$address->id}.", 400);
        }

        $carts = Cart::listFromUserId($id);
        if ($carts) {
            $cartsIds = array_map(fn (Cart $cart): int => $cart->id, $carts);
            $message = count($carts) === 1 ? "ao carrinho" : "aos carrinhos";
            throw new HttpException("Não foi possível remover o usuário $id, pois, está vinculado $message " . implode(", ", $cartsIds) . ".", 400);
        }

        $orders = Order::listFromUserId($id);
        if ($orders) {
            $ordersIds = array_map(fn (Order $order): int => $order->id, $orders);
            $message = count($orders) === 1 ? "ao pedido" : "aos pedidos";
            throw new HttpException("Não foi possível remover o usuário $id, pois, está vinculado $message " . implode(", ", $ordersIds) . ".", 400);
        }

        $response->getBody()->write(json_encode($user->delete()));

        $sessionUser = User::loadFromSession();
        if ($sessionUser && $sessionUser->id === $user->id) {
            User::clearSession();
        }

        return $response;
    }


    /**
     * Realiza o login do usuário
     *
     * @param Request             $request  Requisição
     * @param Response            $response Resposta
     * @param array<string,mixed> $args     Argumentos da URL
     *
     * @static
     *
     * @return Response
     */
    public static function login(Request $request, Response $response, array $args): Response
    {
        $data = (array) $request->getParsedBody();
        $user = User::loadFromLogin($data["login"] ?? "");

        if ($user && password_verify($data["password"] ?? "", $user->password)) {
            $user->saveInSession();

            if ($cart = Cart::loadFromSessionId()) {
                $cart->idUser = $user->id;
                $cart->save();
            }

            $userLog = UserLog::loadFromSession();
            $userLog->description = "Login";
            $userLog->save();

            $response->getBody()->write(json_encode($user));
            return $response;
        }

        throw new HttpException("Usuário inexistente ou senha inválida.", 401);
    }


    /**
     * Realiza o logout do usuário
     *
     * @param Request             $request  Requisição
     * @param Response            $response Resposta
     * @param array<string,mixed> $args     Argumentos da URL
     *
     * @static
     *
     * @return Response
     */
    public static function logout(Request $request, Response $response, array $args): Response
    {
        $userLog = UserLog::loadFromSession();
        $user = User::loadFromSession()?->clearSession();

        $response->getBody()->write(json_encode($user));

        if ($user) {
            $userLog->idUser = $user->id;
            $userLog->description = "Logout";
            $userLog->save();
        }

        return $response;
    }


    /**
     * Retorna o endereço do usuário a partir do ID informado na URL
     *
     * @param Request             $request  Requisição
     * @param Response            $response Resposta
     * @param array<string,mixed> $args     Argumentos da URL
     *
     * @static
     *
     * @return Response
     */
    public static function getAddress(Request $request, Response $response, array $args): Response
    {
        $id = self::int($args["idUser"], true, "idUser");

        $sessionUser = User::loadFromSession();
        if ($sessionUser->id !== $id && !$sessionUser->isAdmin) {
            throw new HttpException("Não foi possível consultar o endereço do usuário $id, pois, você não possui permissão.", 400);
        }

        $address = Address::loadFromUserId($id);
        $response->getBody()->write(json_encode($address));

        return $response->withStatus($address ? 200 : 204);
    }
}
