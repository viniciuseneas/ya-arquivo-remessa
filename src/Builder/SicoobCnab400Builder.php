<?php

namespace Umbrella\Ya\RemessaBoleto\Builder;

use Umbrella\Ya\RemessaBoleto\Enum\BancoEnum;


class SicoobCnab400Builder extends Builder
{
    /**
     * Dados configurados no arquivo "src/config/params.yml"
     * @var array
     */
    protected $dadosBoleto;

    /**
     * Dados recebidos por parametro contendo dados referente a geracao dinamica do boleto
     * @var array
     */
    protected $detalhesBoleto;


    /**
     * @param array $detalhesDoBoleto [description]
     */
    public function __construct(array $detalhesDoBoleto)
    {
        parent::__construct(BancoEnum::SICOOB);

        $this->detalhesBoleto = $detalhesDoBoleto;
    }

    public function builder()
    {
        return $this;
    }


    public function montarArquivo()
    {
        return "";
    }

}
