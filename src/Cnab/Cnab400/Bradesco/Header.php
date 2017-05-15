<?php

namespace Umbrella\Ya\RemessaBoleto\Cnab\Cnab400\Bradesco;

class Header
{
    /**
     * @var int
     */
    protected $identificacaoRegistro = 0;

    /**
     * @var int
     */
    protected $identificacaoArquivo = 1;

    /**
     * @var string
     */
    protected $literalRemessa = 'REMESSA';

    /**
     * @var string
     */
    protected $codigoServico = '01';

    /**
     * @var string
     */
    protected $literalServico = 'COBRANCA';

    /**
     * Será fornecido pelo Bradesco, quando do Cadastramento.
     * @var string
     */
    protected $codigoEmpresa;

    /**
     * @var string
     */
    protected $razaoSocial;

    /**
     * @var int
     */
    protected $numeroBradesco = 237;

    /**
     * @var string
     */
    protected $nomeBanco = 'Bradesco';

    /**
     * @var string
     */
    protected $dataGeracao;

    /**
     * @var string
     */
    protected $identificacaoSistema = 'MX';

    /**
     * @var string
     */
    protected $sequencialRemessa;

    /**
     * @var string
     */
    protected $sequencialRegistro;

    /**
     * @return int
     */
    public function getIdentificacaoRegistro()
    {
        return $this->identificacaoRegistro;
    }

    /**
     * @return int
     */
    public function getIdentificacaoArquivo()
    {
        return $this->identificacaoArquivo;
    }

    /**
     * @return string
     */
    public function getLiteralRemessa()
    {
        return $this->literalRemessa;
    }

    /**
     * @return string
     */
    public function getCodigoServico()
    {
        return $this->codigoServico;
    }

    /**
     * @return string
     */
    public function getLiteralServico()
    {
        return $this->literalServico;
    }

    /**
     * @return mixed
     */
    public function getCodigoEmpresa()
    {
        return $this->codigoEmpresa;
    }

    /**
     * @param mixed $codigoEmpresa
     */
    public function setCodigoEmpresa($codigoEmpresa)
    {
        $this->codigoEmpresa = str_pad($codigoEmpresa, 20, 0, STR_PAD_RIGHT);
    }

    /**
     * @return mixed
     */
    public function getRazaoSocial()
    {
        return $this->razaoSocial;
    }

    /**
     * @param mixed $razaoSocial
     */
    public function setRazaoSocial($razaoSocial)
    {
        $this->razaoSocial = str_pad($razaoSocial, 30, ' ', STR_PAD_RIGHT);
    }

    /**
     * @return int
     */
    public function getNumeroBradesco()
    {
        return $this->numeroBradesco;
    }

    /**
     * @return mixed
     */
    public function getNomeBanco()
    {
        return $this->nomeBanco;
    }

    /**
     * @return mixed
     */
    public function getDataGeracao()
    {
        return $this->dataGeracao;
    }

    /**
     * @param mixed $dataGeracao
     */
    public function setDataGeracao($dataGeracao)
    {
        $this->dataGeracao = $dataGeracao;
    }

    /**
     * @return mixed
     */
    public function getIdentificacaoSistema()
    {
        return $this->identificacaoSistema;
    }

    /**
     * @return mixed
     */
    public function getSequencialRemessa()
    {
        return $this->sequencialRemessa;
    }

    /**
     * @param mixed $sequencialRemessa
     */
    public function setSequencialRemessa($sequencialRemessa)
    {
        $this->sequencialRemessa = str_pad($sequencialRemessa, 7, 0, STR_PAD_RIGHT);
    }

    /**
     * @return mixed
     */
    public function getSequencialRegistro()
    {
        return $this->sequencialRegistro;
    }

    /**
     * @param mixed $sequencialRegistro
     */
    public function setSequencialRegistro($sequencialRegistro)
    {
        $this->sequencialRegistro = str_pad($sequencialRegistro, 6, 0, STR_PAD_RIGHT);
    }
}
