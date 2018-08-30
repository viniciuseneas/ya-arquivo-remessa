<?php

namespace Umbrella\Ya\RemessaBoleto\Modulo;

/**
 * Interface ModuloInterface
 * @package Umbrella\Ya\RemessaBoleto\Modulo
 */
interface ModuloInterface
{
    /**
     * @param string $numero
     * @return mixed
     */
    public function calcularDigitoVerificador(string $numero);
}