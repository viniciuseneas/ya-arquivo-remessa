<?php


namespace Umbrella\Ya\RemessaBoleto\Cnab;

use Umbrella\Ya\RemessaBoleto\Enum\BancoEnum;
use Umbrella\Ya\RemessaBoleto\Builder\BradescoCnab400Builder;
use Umbrella\Ya\RemessaBoleto\Builder\SicoobCnab400Builder;

class RemessaFactory
{

    /**
     * Caminho da pasta onde salva o arquivo
     * @var string
     */
    private $path;

    /**
     * caminho absoluto do arquivo de remessa
     * @var string
     */
    private $remessaFile;

    /**
     * builder do arquivo cnab de remessa
     */
    private $cnabBuilder;

    /**
     * cria o arquivo de remesssa
     * @return RemessaFactory
     */
    public function create(string $path, int $bancoIdentificador, array $dadosArrecadacao)
    {
        try {

            return $this
                ->path($path)
                ->configure($bancoIdentificador, $dadosArrecadacao)
                ->build()
                ->createFile()
            ;
        } catch (\Exception $e) {
            var_dump($e);
            exit;
        } catch (\TypeError $typeError) {
            var_dump($typeError);
            exit;
        }
    }

    /**
     * Define o path
     * @param  string $path
     * @return RemessaFactory
     */
    private function path(string $path)
    {
        if (!is_dir($path) || !is_writable($path)) {
            throw new \Exception("Local especificado para gravar o arquivo é invalido ou não é permitido gravar o arquivo na pasta {$path}");
        }
        $this->path = rtrim($path, "/");
        return $this;
    }

    /**
     * define a classe que gera o arquivo
     * @param  int    $bancoIdentificador
     * @param  array  $dadosArrecadacao
     * @return RemessaFactory
     */
    private function configure(int $bancoIdentificador, array $dadosArrecadacao)
    {
        echo "<b>[#" . BancoEnum::getNomeBanco($bancoIdentificador) ."-->Builder(); ]</b><br/><br/>";

        switch ($bancoIdentificador) {
            case BancoEnum::BRADESCO:
                $this->cnabBuilder = new BradescoCnab400Builder($dadosArrecadacao);
                break;
            case BancoEnum::SICOOB:
                $this->cnabBuilder = new SicoobCnab400Builder($dadosArrecadacao);
                break;
            default:
                throw new \Exception("Codigo do Banco não suportado: {$bancoIdentificador}");
                break;
        }

        return $this;
    }

    /**
     * chama a classe para atribuir os dados do arquivo de remessa
     * @return RemessaFactory
     */
    private function build()
    {
        $this->cnabBuilder->build();
        return $this;
    }

    /**
     * [createFile description]
     * @return RemessaFactory
     */
    private function createFile()
    {
        $this->remessaFile = $this->cnabBuilder->montarArquivo($this->path);
        return $this;
    }
}
