<?php

namespace Umbrella\Ya\RemessaBoleto\Cnab\Cnab400\Bradesco;

class Trailler
{
    /**
     * @var int
     */
    protected $identificacaoRegistro = 9;

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
        $this->sequencialRegistro = str_pad($sequencialRegistro, 6, 0, STR_PAD_LEFT);
    }


    public function getTraillerToString()
    {
        return $this->getIdentificacaoRegistro()
            . str_pad('', 393, ' ', STR_PAD_RIGHT)
            . $this->getSequencialRegistro();
    }
}
