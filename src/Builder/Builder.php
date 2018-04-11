<?php

namespace Umbrella\Ya\RemessaBoleto\Builder;

use Symfony\Component\Yaml\Yaml;
use Umbrella\Ya\RemessaBoleto\Enum\BancoEnum;

class Builder
{
    /**
     * arquivo que contem os dados da geracao do boleto
     */
    const CONFIG_FILE = "src/config/params.yml";

    /**
     * @param int $bancoIdentificador
     */
    public function __construct(int $bancoIdentificador)
    {
        if (!file_exists(self::CONFIG_FILE)) {
            throw new \Exception('Arquivo de configuração nao localizado: {self::CONFIG_FILE}');
        }

        $this->carregarDadosBoletoBanco($bancoIdentificador);
    }

    /**
     * Carrega os dados de acordo com banco passado no parametro.
     * @param  int    $bancoIdentificador
     * @return void
     */
    private function carregarDadosBoletoBanco(int $bancoIdentificador)
    {
        switch ($bancoIdentificador) {
            case BancoEnum::BRADESCO:
                $this->dadosBoleto = Yaml::parseFile(self::CONFIG_FILE)['cnab400']['bradesco'];
                break;

            case BancoEnum::SICOOB:
                $this->dadosBoleto = Yaml::parseFile(self::CONFIG_FILE)['cnab400']['sicoob'];
                break;

            default:
                throw new \Exception("Dados de boleto do banco não localizado {self::CONFIG_FILE}");
                break;
        }
    }

}
