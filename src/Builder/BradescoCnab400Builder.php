<?php

namespace Umbrella\Ya\RemessaBoleto\Builder;

use Umbrella\Ya\RemessaBoleto\Enum\BancoEnum;
use Umbrella\Ya\RemessaBoleto\Cnab\Cnab400\Bradesco\Transacao;
use Umbrella\Ya\RemessaBoleto\Cnab\Cnab400\Bradesco\Header;
use Umbrella\Ya\RemessaBoleto\Cnab\Cnab400\Bradesco\File;
use Umbrella\Ya\RemessaBoleto\Cnab\Cnab400\Bradesco\Trailler;

class BradescoCnab400Builder extends Builder
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

    public function __construct(array $detalhesDoBoleto)
    {
        parent::__construct(BancoEnum::BRADESCO);
        $this->detalhesBoleto = $detalhesDoBoleto;
    }

    /**
     * funcao para geracao do arquivo de remessa do cnab400 do boleto bradesco
     * @return string [caminho completo do arquivo de remessa]
     */
    public function builder()
    {
        return $this
            ->transacao()
            ->header()
            ->trailler()
            ->montarArquivo()
            ;
    }

    /**
     * gerador da trasacao do arquivo de remessa cnab400 bradesco
     * @return Transacao
     */
    protected function transacao()
    {
        $transacao = new Transacao();
        // $carteira = str_pad($this->convenioBancario->carteira()->nome, 3, 0, STR_PAD_LEFT);
        // $agencia = str_pad($this->convenioBancario->agencia, 5, 0, STR_PAD_LEFT);
        // $conta = str_pad($this->convenioBancario->conta, 7, 0, STR_PAD_LEFT);
        // $idBeneficiaria = "0{$carteira}{$agencia}{$conta}{$this->convenioBancario->digitoConta}";

        // $stringFiltrada = (new \Comum_Filter_IntegerFilter())
        //     ->getIntegerFromString(substr($this->dam->nossoNumero, 2, 12))
        // ;
        // $nossoNumeroSemDigito = substr($stringFiltrada, 0, 11);

        // $transacao->setIdentificacaoEmpresaBeneficiaria($idBeneficiaria);
        // $transacao->setIdentificacaoTituloBanco($nossoNumeroSemDigito);
        // $transacao->setDigitoAutoConferencia(mb_substr($this->dam->nossoNumero, strlen($this->dam->nossoNumero) - 1));
        // $transacao->setCondicaoEmissao(2);
        // $transacao->setEmiteBoletoDebitoAutomatico('N');
        // $transacao->setOperacaoBanco(str_pad('', 10, ' '));
        // $transacao->setIdentificacaoOcorrencia('01');
        // $transacao->setCodigoBancoDebitado(0);
        // $transacao->setNumeroDocumento($this->dam->numeroDocumento);
        // $transacao->setDataVencimentoTitulo(
        //     (new \DateTime($this->dam->dataVencimento))->format('dmy')
        // );
        // $transacao->setValorTitulo(str_replace(['.', ','], '', $this->dam->valor));
        // $transacao->setEspecieTitulo('99');
        // $transacao->setDataEmissaoTitulo((new \DateTime($this->dam->dataEmissao))->format('dmy'));
        // $transacao->setPrimeiraInstrucao('00');
        // $transacao->setSegundaInstrucao('00');
        // $transacao->setTipoInscricaoPagador('01');
        // $transacao->setNumeroInscricaoPagador($this->pagador->cpfCnpj);
        // $transacao->setNomePagador($this->pagador->nome);
        // $enderecoSemAcento = (new \Comum_Filter_StringFilter())->removeAcentos($this->pagador->endereco);
        // $transacao->setEnderecoPagador($enderecoSemAcento);
        // $transacao->setCep(substr($this->pagador->cep, 0, 5));
        // $transacao->setSufixoCep(substr($this->pagador->cep, 5, 3));
        // $transacao->setSequencialRegistro(str_pad('1', 6, 0));

        // $transacao->setValorPorDiaATrasado('0');
        // $transacao->setDataLimiteDesconto(str_pad('', 6, '0'));
        // $transacao->setValorDesconto('0');
        // $transacao->setValorIof('0');
        // $transacao->setValorAbatimento('0');
        // $transacao->setSegundaMensagem(' ');
        // $transacao->setNumeroControleParticipante('0');
        // $transacao->setMulta(0);
        // $transacao->setPercentualMulta(0);
        // $transacao->setDescontoBonificacao('0');
        // $transacao->setIndicadorRateioCredito(' ');
        // $transacao->setAgenciaDebito('0');
        // $transacao->setDigitoAgenciaDebito('0');
        // $transacao->setRazaoContaCorrente('0');
        // $transacao->setContaCorrente('0');
        // $transacao->setDigitoContaCorrente('0');
        // $transacao->setAvisoDebitoAutomatico(2);
        // $transacao->setPrimeiraMensagem(' ');

        return $transacao;
    }

    /**
     * gerador do header do arquivo de remessa do bradesco cnab400
     * @return Header
     */
    protected function header()
    {
        $header = new Header();
        // $header->setRazaoSocial(mb_strtoupper(mb_substr($this->convenioBancario->orgao()->descricao, 0, 30)));
        // $header->setCodigoEmpresa($this->convenioBancario->convenio);
        // $header->setDataGeracao((new \DateTime())->format('dmy'));
        // $header->setSequencialRegistro(1);
        // $header->setSequencialRemessa($this->idRemessa);
        return $header;
    }

    /**
     * Gerador do triller do bradesco cnab400
     * @return Trailler
     */
    protected function trailler()
    {
        $trailler = new Trailler();
        $trailler->setSequencialRegistro($sequencialRegistro);

        return $trailler;
    }

    public function montarArquivo(string $path)
    {
        $fileName = (new File())->buildName();
        $fullpath = $path . '/' . $fileName;

        $file = fopen($fullpath, 'w');

        if (!file_exists($fullpath)) {
            throw new \Exception("Não foi possivel abrir o arquivo para criar a remessa {$fullpath}");
        }

        // $stringHeader = $header->getIdentificacaoRegistro()
        //     . $header->getIdentificacaoArquivo()
        //     . $header->getLiteralRemessa()
        //     . $header->getCodigoServico()
        //     . str_pad($header->getLiteralServico(), 15, ' ', STR_PAD_RIGHT)
        //     . $header->getCodigoEmpresa()
        //     . $header->getRazaoSocial()
        //     . $header->getNumeroBradesco()
        //     . str_pad($header->getNomeBanco(), 15, ' ', STR_PAD_RIGHT)
        //     . $header->getDataGeracao()
        //     . str_pad('', 8, ' ', STR_PAD_RIGHT)
        //     . $header->getIdentificacaoSistema()
        //     . $header->getSequencialRemessa()
        //     . str_pad('', 277, ' ', STR_PAD_RIGHT)
        //     . $header->getSequencialRegistro()
        //     . "\n";

        // fwrite($file, $stringHeader);

        $sequencialRegistro = 2;

        // $transacao->setSequencialRegistro($sequencialRegistro);

        // $stringTransacao = $transacao->getIdentificacaoRegistro()
        //     . $transacao->getAgenciaDebito()
        //     . $transacao->getDigitoAgenciaDebito()
        //     . $transacao->getRazaoContaCorrente()
        //     . $transacao->getContaCorrente()
        //     . $transacao->getDigitoContaCorrente()
        //     . $transacao->getIdentificacaoEmpresaBeneficiaria()
        //     . $transacao->getNumeroControleParticipante()
        //     . $transacao->getCodigoBancoDebitado()
        //     . $transacao->getMulta()
        //     . $transacao->getPercentualMulta()
        //     . $transacao->getIdentificacaoTituloBanco()
        //     . $transacao->getDigitoAutoConferencia()
        //     . $transacao->getDescontoBonificacao()
        //     . $transacao->getCondicaoEmissao()
        //     . $transacao->getEmiteBoletoDebitoAutomatico()
        //     . $transacao->getOperacaoBanco()
        //     . $transacao->getIndicadorRateioCredito()
        //     . $transacao->getAvisoDebitoAutomatico()
        //     . str_pad('', 2, ' ', STR_PAD_RIGHT)
        //     . $transacao->getIdentificacaoOcorrencia()
        //     . $transacao->getNumeroDocumento()
        //     . $transacao->getDataVencimentoTitulo()
        //     . $transacao->getValorTitulo()
        //     . $transacao->getBancoCobrador()
        //     . $transacao->getAgenciaDepositaria()
        //     . $transacao->getEspecieTitulo()
        //     . $transacao->getIdentificacao()
        //     . $transacao->getDataEmissaoTitulo()
        //     . $transacao->getPrimeiraInstrucao()
        //     . $transacao->getSegundaInstrucao()
        //     . $transacao->getValorPorDiaATrasado()
        //     . $transacao->getDataLimiteDesconto()
        //     . $transacao->getValorDesconto()
        //     . $transacao->getValorIof()
        //     . $transacao->getValorAbatimento()
        //     . $transacao->getTipoInscricaoPagador()
        //     . $transacao->getNumeroInscricaoPagador()
        //     . $transacao->getNomePagador()
        //     . $transacao->getEnderecoPagador()
        //     . $transacao->getPrimeiraMensagem()
        //     . $transacao->getCep()
        //     . $transacao->getSufixoCep()
        //     . ($transacao->getSacador() ? : $transacao->getSegundaMensagem())
        //     . $transacao->getSequencialRegistro()
        //     . "\n";

        $sequencialRegistro++;
        // fwrite($file, $stringTransacao);


        $trailler = new Trailler();
        $trailler->setSequencialRegistro($sequencialRegistro);

        // $stringTrailler = $trailler->getIdentificacaoRegistro()
        //     . str_pad('', 393, ' ', STR_PAD_RIGHT)
        //     . $trailler->getSequencialRegistro();

        // fwrite($file, $stringTrailler);

        fclose($file);

        return $fullpath;
    }

}
