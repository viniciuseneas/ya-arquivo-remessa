<?php

namespace Umbrella\Ya\RemessaBoleto;

use Umbrella\Ya\RemessaBoleto\Cnab\Cnab400\Bradesco\File;
use Umbrella\Ya\RemessaBoleto\Cnab\Cnab400\Bradesco\Header;
use Umbrella\Ya\RemessaBoleto\Cnab\Cnab400\Bradesco\Trailler;
use Umbrella\Ya\RemessaBoleto\Type\StringBuilder;

class RemFactory
{
    protected $savePath;

    public function __construct($savePath = null)
    {
        $this->savePath = $savePath;
    }

    public function build(Header $header, array $transacoes)
    {
        $file = fopen($this->savePath . '/' . (new File())->buildName(), 'w');

        $stringHeader = $header->getIdentificacaoRegistro()
            . $header->getIdentificacaoArquivo()
            . $header->getLiteralRemessa()
            . $header->getCodigoServico()
            . StringBuilder::espacos($header->getLiteralServico(), 15)
            . $header->getCodigoEmpresa()
            . $header->getRazaoSocial()
            . $header->getNumeroBradesco()
            . StringBuilder::espacos($header->getNomeBanco(), 15)
            . $header->getDataGeracao()
            . StringBuilder::espacos(' ', 8)
            . $header->getIdentificacaoSistema()
            . $header->getSequencialRemessa()
            . StringBuilder::espacos(' ', 277)
            . $header->getSequencialRegistro()
            . "\n";

        fwrite($file, $stringHeader);

        foreach ($transacoes as $transacao) {
            $stringTransacao = $transacao->getIdentificacaoRegistro()
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
                . $transacao->getDescontoBonificacao()
                . $transacao->getCondicaoEmissao()
                . $transacao->getEmiteBoletoDebitoAutomatico()
                . $transacao->getOperacaoBanco()
                . $transacao->getIndicadorRateioCredito()
                . StringBuilder::espacos(' ', 2)
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
                . $transacao->getSacador()
                . $transacao->getSegundaMensagem()
                . $transacao->getSequencialRegistro()
                . "\n";

            fwrite($file, $stringTransacao);
        }

        $trailler = new Trailler();

        $stringTrailler = $trailler->getIdentificacaoRegistro()
            . StringBuilder::espacos(' ', 393)
            . StringBuilder::zeros(1, 6);

        fwrite($file, $stringTrailler);

        fclose($file);

        return $this->savePath;
    }
}
