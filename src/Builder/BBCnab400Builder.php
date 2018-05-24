<?php

namespace Umbrella\Ya\RemessaBoleto\Builder;

use Umbrella\Ya\RemessaBoleto\Enum\BancoEnum;
use Umbrella\Ya\RemessaBoleto\Cnab\Cnab400\BB\Detalhe;
use Umbrella\Ya\RemessaBoleto\Cnab\Cnab400\BB\Header;
use Umbrella\Ya\RemessaBoleto\Cnab\Cnab400\BB\File;
use Umbrella\Ya\RemessaBoleto\Cnab\Cnab400\BB\Trailler;

class BBCnab400Builder extends Builder
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
        parent::__construct(BancoEnum::BANCO_DO_BRASIL);
        $this->detalhesBoleto = $detalhesDoBoleto;
    }

    /**
     * funcao para geracao do arquivo de remessa do cnab400 do boleto bradesco
     * @return string [caminho completo do arquivo de remessa]
     */
    public function build()
    {
        return $this
            ->detalhes()
            ->header()
            ->trailler()
            ;
    }

    /**
     * gerador da trasacao do arquivo de remessa cnab400 bradesco
     * @return BBCnab400Builder
     */
    protected function detalhes()
    {
        $seqConvenio            = $this->getSeqConvenio($this->detalhesBoleto['convenios']);
        $convenioBancario       = $this->detalhesBoleto['convenios'][$seqConvenio];
        $documentosArrecadacao  = $this->detalhesBoleto['transacoes'][$seqConvenio];

        $arrDetalhes = [];

        foreach ($documentosArrecadacao['dam'] as $key => $documento) {
            $detalhe = new Detalhe;

            $detalhe->setIdentificacaoRegistro(7);
            $detalhe->setTipoInscricaoCedente(
                strlen($convenioBancario['orgao']['pessoa']['cpfCnpj']) > 11 ? "02" : "01"
            );
            $detalhe->setNumeroCPFCNPJCedente($convenioBancario['orgao']['pessoa']['cpfCnpj']);
            $detalhe->setPrefixoAgencia($convenioBancario['agencia']);
            $detalhe->setPrefixoAgenciaDV($convenioBancario['digitoAgencia']);
            $detalhe->setContaCorrenteCedente($convenioBancario['conta']);
            $detalhe->setContaCorrenteDVCedente($convenioBancario['digitoConta']);
            $detalhe->setConvenioCobrancaCedente($convenioBancario['convenio']);
            $detalhe->setCodigoControleEmpresa('');
            $detalhe->setNossoNumero($documento['nossoNumero']);
            $detalhe->setNumeroPrestacao('00');
            $detalhe->setGrupoValor('00');
            $detalhe->setComplementoRegistroBranco1('');
            $detalhe->setMsgSacadorAvalista(' ');
            $detalhe->setPrefixoTitulo('');
            $detalhe->setVariacaoCarteira($documento['carteira']['nome']);
            $detalhe->setContaCaucao('0');
            $detalhe->setNumeroBordero('000000');
            $detalhe->setTipoCobranca('');
            $detalhe->setCarteiraCobranca('');
            $detalhe->setComando('01');
            $detalhe->setNumTituloCedente('');
            $detalhe->setDtVencimento((new \DateTime($documento['dataVencimento']))->format('dmy'));
            $detalhe->setVlTitulo($documento['valor']);
            $detalhe->setEspecieTitulo('26');
            $detalhe->setNumBanco('001');
            $detalhe->setPrefixoAgenciaCobradora('0000');
            $detalhe->setPrefixoAgenciaDVCobranca(' ');
            $detalhe->setEspecieTitulo('');
            $detalhe->setAceiteTitulo('N');
            $detalhe->setDtEmissaoTitulo((new \DateTime($documento['dataEmissao']))->format('dmy'));
            $detalhe->setInstrucaoCodificada1('00');
            $detalhe->setInstrucaoCodificada2('00');
            $detalhe->setJurisMoraDia('');
            $detalhe->setDtLimiteConcessaoDesconto('');
            $detalhe->setVlDesconto('');
            $detalhe->setVlIOF('');
            $detalhe->setVlAbatimento('');
            $detalhe->setTipoOperacaoSacado(strlen($documento['pessoa']['cpfCnpj']) > 11 ? "02" : "01");
            $detalhe->setCpfCnpjSacado($documento['pessoa']['cpfCnpj']);
            $detalhe->setNomeSacado($documento['pessoa']['nome']);
            $detalhe->setComplementoRegistroBranco2('');
            $detalhe->setEnderecoSacado($documento['pessoa']['endereco']);
            $detalhe->setBairroSacado($documento['pessoa']['bairro']);
            $detalhe->setCepSacado($documento['pessoa']['cep']);
            $detalhe->setCidadeSacado($documento['pessoa']['municipio']['nome']);
            $detalhe->setUfCidadeSacado($documento['pessoa']['municipio']['uf']['sigla']);
            $detalhe->setObsMensagemSacadorAvalista(''); /***/
            $detalhe->setNumDiasProtesto(''); /***/
            $detalhe->setComplementoRegistroBranco3('');

            $arrDetalhes[] = $detalhe;
        }
        $this->detalhes = $arrDetalhes;
        return $this;
    }

    /**
     * gerador do header do arquivo de remessa do bradesco cnab400
     * @return BBCnab400Builder
     */
    protected function header()
    {
        $seqConvenio    = $this->getSeqConvenio($this->detalhesBoleto['convenios']);
        $header         = new Header();

        $header->setIdRegistroHeader($this->dadosBoleto['identificacao_registro']);
        $header->setTipoOperacao($this->dadosBoleto['identificacao_operacao']);
        $header->setTipoOperacaoExtenso($this->dadosBoleto['literal_operacao']);
        $header->setTipoServico($this->dadosBoleto['tipo_servico']);
        $header->setTipoServicoExtenso($this->dadosBoleto['literal_servico']);
        $header->setIdBanco($this->dadosBoleto['id_banco']);

        $header->setComplementoRegistroBranco('');
        $header->setComplementoRegistro('');
        $header->setDtGravacao((new \DateTime())->format('dmy'));
        $header->setSequencialRemessa('1');
        $header->setComplementoRegistroBranco2('');
        $header->setComplementoRegistroBranco3('');

        $header->setNomeCedente(mb_strtoupper('NOME CEDENTE LTDA'));
        $header->setPrefixoAgencia('1234');
        $header->setPrefixoAgenciaDV('1');
        $header->setContaCorrente('1231231');
        $header->setContaCorrenteDV('1');
        $header->setNumeroConvenioLider($seqConvenio);

        $header->setSequencialRegistro('1');

        $this->header = $header;
        return $this;
    }

    /**
     * Gerador do triller do bradesco cnab400
     * @return BBCnab400Builder
     */
    protected function trailler()
    {
        $trailler = new Trailler();
        $trailler->setSequencialRegistro(123);
        $this->trailler = $trailler;
        return $this;
    }

    /**
     * @param string $path
     * @return string
     * @throws \Exception
     */
    public function montarArquivo(string $path)
    {
        $fileName = (new File())->buildName();
        $fullpath = $path . '/' . $fileName;

        $file = fopen($fullpath, 'w');

        if (!file_exists($fullpath)) {
            throw new \Exception("Não foi possivel abrir o arquivo para criar a remessa {$fullpath}");
        }

        $header     = $this->header;
        $transacoes = $this->detalhes;
        $trailler   = $this->trailler;

        $stringHeader = $header->getHeaderToString();

        fwrite($file, $stringHeader . "\n");

        $sequencialRegistro = 2;

        foreach ($transacoes as $transacao) {
            $transacao->setSequencialRegistro($sequencialRegistro++);
            $stringTransacao = $transacao->getDetalhesToString();
            fwrite($file, $stringTransacao . "\n");
        }

        $trailler->setSequencialRegistro($sequencialRegistro);
        $stringTrailler = $trailler->getTraillerToString();

        fwrite($file, $stringTrailler);
        fclose($file);
        return $fullpath;
    }
}
