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
            $this
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
        print_r("factory: <br/><pre>\n" . print_r($this,1) . "</pre>");
    }

    /**
     * Define o path
     * @param  string $path
     * @return RemessaFactory
     */
    private function path(string $path)
    {
        // echo("\npath defined: <b>{$path}</b><br/>\n");
        $this->path = $path;
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
        echo "<b>[" . BancoEnum::getNomeBanco($bancoIdentificador) ."]</b><br/><br/>";

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

        var_dump($this->cnabBuilder);

        return $this;
    }

    /**
     * [createFile description]
     * @return RemessaFactory
     */
    private function createFile()
    {
        $this->remessaFile = $this->cnabBuilder->montarArquivo($this->path);
        var_dump($this->remessaFile);
        echo "<hr>";
        return $this;
    }
}
