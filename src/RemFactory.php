<?php

namespace Umbrella\Ya\RemessaBoleto;

use Umbrella\Ya\RemessaBoleto\Cnab\Cnab400\Bradesco\File;
use Umbrella\Ya\RemessaBoleto\Cnab\Cnab400\Bradesco\Header;
use Umbrella\Ya\RemessaBoleto\Cnab\Cnab400\Bradesco\Trailler;

class RemFactory
{
    protected $savePath;

    public function __construct($savePath = null)
    {
        $this->savePath = $savePath;
    }

    public function build(Header $header, array $transacoes)
    {
        $fileName = (new File())->buildName();
        $file = fopen($this->savePath . '/' . $fileName, 'w');

        $stringHeader = $header->getIdentificacaoRegistro()
            . $header->getIdentificacaoArquivo()
            . $header->getLiteralRemessa()
            . $header->getCodigoServico()
            . str_pad($header->getLiteralServico(), 15, ' ', STR_PAD_RIGHT)
            . $header->getCodigoEmpresa()
            . $header->getRazaoSocial()
            . $header->getNumeroBradesco()
            . str_pad($header->getNomeBanco(), 15, ' ', STR_PAD_RIGHT)
            . $header->getDataGeracao()
            . str_pad('', 8, ' ', STR_PAD_RIGHT)
            . $header->getIdentificacaoSistema()
            . $header->getSequencialRemessa()
            . str_pad('', 277, ' ', STR_PAD_RIGHT)
            . $header->getSequencialRegistro()
            . "\n";

        fwrite($file, $stringHeader);

        $sequencialRegistro = 2;

        foreach ($transacoes as $transacao) {
            $transacao->setSequencialRegistro($sequencialRegistro);

            $stringTransacao = $transacao->getIdentificacaoRegistro()
                . $transacao->getAgenciaDebito()
                . $transacao->getDigitoAgenciaDebito()
                . $transacao->getRazaoContaCorrente()
                . $transacao->getContaCorrente()
                . $transacao->getDigitoContaCorrente()
                . $transacao->getIdentificacaoEmpresaBeneficiaria()
                . $transacao->getNumeroControleParticipante()
                . $transacao->getCodigoBancoDebitado()
                . $transacao->getMulta()
                . $transacao->getPercentualMulta()
                . $transacao->getIdentificacaoTituloBanco()
                . $transacao->getDigitoAutoConferencia()
                . $transacao->getDescontoBonificacao()
                . $transacao->getCondicaoEmissao()
                . $transacao->getEmiteBoletoDebitoAutomatico()
                . $transacao->getOperacaoBanco()
                . $transacao->getIndicadorRateioCredito()
                . $transacao->getAvisoDebitoAutomatico()
                . str_pad('', 2, ' ', STR_PAD_RIGHT)
                . $transacao->getIdentificacaoOcorrencia()
                . $transacao->getNumeroDocumento()
                . $transacao->getDataVencimentoTitulo()
                . $transacao->getValorTitulo()
                . $transacao->getBancoCobrador()
                . $transacao->getAgenciaDepositaria()
                . $transacao->getEspecieTitulo()
                . $transacao->getIdentificacao()
                . $transacao->getDataEmissaoTitulo()
                . $transacao->getPrimeiraInstrucao()
                . $transacao->getSegundaInstrucao()
                . $transacao->getValorPorDiaATrasado()
                . $transacao->getDataLimiteDesconto()
                . $transacao->getValorDesconto()
                . $transacao->getValorIof()
                . $transacao->getValorAbatimento()
                . $transacao->getTipoInscricaoPagador()
                . $transacao->getNumeroInscricaoPagador()
                . $transacao->getNomePagador()
                . $transacao->getEnderecoPagador()
                . $transacao->getPrimeiraMensagem()
                . $transacao->getCep()
                . $transacao->getSufixoCep()
                . ($transacao->getSacador() ? : $transacao->getSegundaMensagem())
                . $transacao->getSequencialRegistro()
                . "\n";

            $sequencialRegistro++;
            fwrite($file, $stringTransacao);
        }

        $trailler = new Trailler();
        $trailler->setSequencialRegistro($sequencialRegistro);

        $stringTrailler = $trailler->getIdentificacaoRegistro()
            . str_pad('', 393, ' ', STR_PAD_RIGHT)
            . $trailler->getSequencialRegistro();

        fwrite($file, $stringTrailler);

        fclose($file);

        return $this->savePath . '/' . $fileName;
    }
}
