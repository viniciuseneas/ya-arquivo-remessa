<?php

namespace Umbrella\Ya\RemessaBoleto\Builder;

use Umbrella\Ya\RemessaBoleto\Enum\BancoEnum;
use Umbrella\Ya\RemessaBoleto\Cnab\Cnab400\Bradesco\Transacao;
use Umbrella\Ya\RemessaBoleto\Cnab\Cnab400\Bradesco\Header;
use Umbrella\Ya\RemessaBoleto\Cnab\Cnab400\Bradesco\File;
use Umbrella\Ya\RemessaBoleto\Cnab\Cnab400\Bradesco\Trailler;
use Umbrella\Ya\RemessaBoleto\Modulo\Modulo11;

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
    public function build()
    {
        return $this
            ->transacao()
            ->header()
            ->trailler();
    }

    /**
     * gerador da trasacao do arquivo de remessa cnab400 bradesco
     * @return Transacao
     */
    protected function transacao()
    {
        $seqConvenio = $this->getSeqConvenio($this->detalhesBoleto['convenios']);
        $convenioBancario = $this->detalhesBoleto['convenios'][$seqConvenio];
        $documentosArrecadacao = $this->detalhesBoleto['transacoes'][$seqConvenio];

        $arrTransacoes = [];

        foreach ($documentosArrecadacao['dam'] as $key => $documento) {
            $transacao = new Transacao;

            $transacao->setAgenciaDebito('0');
            $transacao->setDigitoAgenciaDebito('0');
            $transacao->setRazaoContaCorrente('0');
            $transacao->setContaCorrente('0');
            $transacao->setDigitoContaCorrente('0');
            $transacao->setIdentificacaoEmpresaBeneficiaria(
                $this->concatenarDados(
                    str_pad($convenioBancario['carteira']['nome'], 3, 0, STR_PAD_LEFT),
                    str_pad($convenioBancario['agencia'], 5, 0, STR_PAD_LEFT),
                    str_pad($convenioBancario['conta'], 7, 0, STR_PAD_LEFT),
                    $convenioBancario['digitoConta']
                )
            );
            $transacao->setNumeroControleParticipante('0');
            $transacao->setCodigoBancoDebitado(0);
            $transacao->setMulta(0);
            $transacao->setPercentualMulta(0);
            $transacao->setIdentificacaoTituloBanco(
                $this->parseInteger(substr($documento['nossoNumero'], 2, 12))
            );
            $digitoVerificador = (new Modulo11())->calcularDigitoVerificador(
                $convenioBancario['carteira']['nome'] . $documento['nossoNumero']
            );
            $transacao->setDigitoAutoConferencia($digitoVerificador);
            $transacao->setDescontoBonificacao('0');
            $transacao->setCondicaoEmissao(2);
            $transacao->setEmiteBoletoDebitoAutomatico('N');
            $transacao->setOperacaoBanco(str_pad('', 10, ' '));
            $transacao->setIndicadorRateioCredito(' ');
            $transacao->setAvisoDebitoAutomatico(2);
            $transacao->setIdentificacaoOcorrencia('01');
            $transacao->setNumeroDocumento($documento['numeroDocumento']);
            $transacao->setDataVencimentoTitulo((new \DateTime($documento['dataVencimento']))->format('dmy'));
            $transacao->setValorTitulo(str_replace(['.', ','], '', $documento['valor']));
            $transacao->setEspecieTitulo('99');
            $transacao->setDataEmissaoTitulo(
                (new \DateTime($documento['dataEmissao']))->format('dmy')
            );
            $transacao->setPrimeiraInstrucao('00');
            $transacao->setSegundaInstrucao('00');
            $transacao->setValorPorDiaATrasado('0');
            $transacao->setDataLimiteDesconto(str_pad('', 6, '0'));
            $transacao->setValorDesconto('0');
            $transacao->setValorIof('0');
            $transacao->setValorAbatimento('0');

            $numeroInscricaoPagador = strlen($documento['pessoa']['cpfCnpj']) === 11 ? '01' : '02';
            $transacao->setTipoInscricaoPagador($numeroInscricaoPagador);
            $transacao->setNumeroInscricaoPagador($documento['pessoa']['cpfCnpj']);
            $transacao->setNomePagador($this->removerAcentos($documento['pessoa']['nome']));
            $transacao->setEnderecoPagador($this->removerAcentos($documento['pessoa']['endereco']));
            $transacao->setPrimeiraMensagem(' ');
            $transacao->setCep(substr($documento['pessoa']['cep'], 0, 5));
            $transacao->setSufixoCep(substr($documento['pessoa']['cep'], 5, 3));
            $transacao->setSegundaMensagem(' ');
            $transacao->setSequencialRegistro(str_pad('1', 6, 0));

            $arrTransacoes[] = $transacao;
        }
        $this->transacoes = $arrTransacoes;

        return $this;
    }

    /**
     * gerador do header do arquivo de remessa do bradesco cnab400
     * @return Header
     */
    protected function header()
    {
        $seqConvenio = $this->getSeqConvenio($this->detalhesBoleto['convenios']);

        $header = new Header();
        $header->setRazaoSocial(
            $this->removerAcentos(mb_strtoupper(
                mb_substr(
                    $this->detalhesBoleto['convenios'][$seqConvenio]['orgao']['descricao'],
                    0,
                    30
                )
            ))
        );
        $header->setCodigoEmpresa($this->detalhesBoleto['convenios'][$seqConvenio]['convenio']);
        $header->setDataGeracao((new \DateTime())->format('dmy'));
        $header->setSequencialRegistro(1);
        $header->setSequencialRemessa($this->detalhesBoleto['totalRemessas']);

        $this->header = $header;

        return $this;
    }

    /**
     * Gerador do triller do bradesco cnab400
     * @return Trailler
     */
    protected function trailler()
    {
        $trailler = new Trailler();
        $trailler->setSequencialRegistro(1);
        $this->trailler = $trailler;

        return $this;
    }

    public function montarArquivo(string $path)
    {
        $fileName = (new File())->buildName();
        $fullpath = $path . '/' . $fileName;

        $file = fopen($fullpath, 'w');

        if (!file_exists($fullpath)) {
            throw new \Exception("Não foi possivel abrir o arquivo para criar a remessa {$fullpath}");
        }

        $header = $this->header;
        $transacoes = $this->transacoes;
        $trailler = $this->trailler;

        $stringHeader = $header->getHeaderToString();

        fwrite($file, $stringHeader . "\n");

        $sequencialRegistro = 2;

        foreach ($transacoes as $transacao) {
            $transacao->setSequencialRegistro($sequencialRegistro);

            $stringTransacao = $transacao->getTransacaoToString();

            $sequencialRegistro++;
            fwrite($file, $stringTransacao . "\n");
        }

        $trailler->setSequencialRegistro($sequencialRegistro);
        $stringTrailler = $trailler->getTraillerToString();

        fwrite($file, $stringTrailler);
        fclose($file);

        return $fullpath;
    }
}
