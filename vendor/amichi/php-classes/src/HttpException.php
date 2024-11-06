<?php

/**
 * PHP version 8.3.12
 *
 * @category GlobalClass
 * @package  Amichi
 * @author   Luiz Amichi <eu@luizamichi.com.br>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/luizamichi/hcode-store
 */

namespace Amichi;

/**
 * Classe que define uma exceção personalizada
 *
 * @category GlobalClass
 * @package  Amichi
 * @author   Luiz Amichi <eu@luizamichi.com.br>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/luizamichi/hcode-store
 */
class HttpException extends \Exception
{
    /**
     * Propriedade
     *
     * @var bool Ambiente de execução é API?
     */
    private bool $_environmentIsApi;


    /**
     * Propriedade
     *
     * @var bool Sucesso na operação?
     */
    private bool $_success;


    /**
     * Propriedade
     *
     * @var bool Modo de depuração?
     */
    private bool $_debug;


    /**
     * Construtor
     *
     * @param string $message   Mensagem da exceção
     * @param int    $code      Código de status de respostas HTTP
     * @param bool   $success   Sucesso na operação?
     * @param bool   $immediate Resultado imediato da exceção?
     *
     * @return void
     */
    public function __construct(string $message, int $code = 500, bool $success = false, bool $immediate = true)
    {
        parent::__construct($message, $code);
        http_response_code($code);

        $this->_success = $success;
        $this->_environmentIsApi = getenv("APPLICATION_ENVIRONMENT") !== "view";
        $this->_debug = getenv("PHP_DEBUG") === "true";

        if ($this->_environmentIsApi) {
            header("Content-type: application/json");
        }

        if ($immediate) {
            $this->return();
        }
    }


    /**
     * Retorna o JSON com o erro
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string) json_encode($this->array(!$this->_debug));
    }


    /**
     * Retorna a classe em formato de vetor
     *
     * @param bool $hideSensitiveInformation Oculta informações sensíveis
     *
     * @return array<string,bool|int|null|string>
     */
    public function array(bool $hideSensitiveInformation = true): array
    {
        $return = [
            "message" => $this->getMessage(),
            "code" => $this->getCode(),
            "success" => $this->_success,
            "file" => null,
            "line" => null,
            "trace" => null,
        ];

        if (!$hideSensitiveInformation) {
            $return["file"] = $this->getFile();
            $return["line"] = $this->getLine();
            $return["trace"] = $this->getTraceAsString();
        }

        return $return;
    }


    /**
     * Imprime o erro em formato JSON/HTML
     *
     * @return void
     */
    public function return(): void
    {
        if (!$this->_environmentIsApi) {
            $page = new Page(["header" => false, "footer" => false]);
            $page->setTpl("error", ["exception" => $this->array(!$this->_debug)]);
            exit($page->getTpl());
        }

        exit($this);
    }
}
