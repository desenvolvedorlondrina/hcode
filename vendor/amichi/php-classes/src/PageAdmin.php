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
 * Classe que renderiza arquivos HTML do painel de administração
 *
 * @category GlobalClass
 * @package  Amichi
 * @author   Luiz Amichi <eu@luizamichi.com.br>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/luizamichi/hcode-store
 */
class PageAdmin extends Page
{
    /**
     * Construtor
     *
     * @param array<string,mixed> $options    Opções de definição do template
     * @param string              $directory  Diretório de templates HTML
     * @param bool                $returnHTML Retorna o HTML?
     *
     * @return void
     */
    public function __construct(array $options = [], string $directory = DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "admin" . DIRECTORY_SEPARATOR, bool $returnHTML = true)
    {
        parent::__construct($options, $directory, $returnHTML);
    }
}
