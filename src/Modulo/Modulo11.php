<?php

namespace Umbrella\Ya\RemessaBoleto\Modulo;

/**
 * Class Modulo11
 * @package Umbrella\Ya\RemessaBoleto\Modulo
 */
class Modulo11 implements ModuloInterface
{
    /**
     * @param string $numero
     * @return int|mixed|string
     */
    public function calcularDigitoVerificador(string $numero)
    {
        $modulo11 = $this->modulo11($numero, 7, 1);
        $digito = 11 - $modulo11;

        if ($digito == 10) {
            $digitoVerificador = "P";
        } elseif ($digito == 11) {
            $digitoVerificador = 0;
        } else {
            $digitoVerificador = $digito;
        }

        return $digitoVerificador;
    }

    /**
     * @param $num
     * @param int $base
     * @param int $resto
     * @return int
     */
    private function modulo11($num, $base = 9, $resto = 0)
    {
        $soma = 0;
        $fator = 2;

        /* Separacao dos numeros */
        for ($i = strlen($num); $i > 0; $i--) {
            // pega cada numero isoladamente
            $numeros[$i] = substr($num, $i - 1, 1);
            // Efetua multiplicacao do numero pelo falor
            $parcial[$i] = $numeros[$i] * $fator;
            // Soma dos digitos
            $soma += $parcial[$i];
            if ($fator == $base) {
                // restaura fator de multiplicacao para 2
                $fator = 1;
            }
            $fator++;
        }

        /* Calculo do modulo 11 */
        if ($resto == 0) {
            $soma *= 10;
            $digito = $soma % 11;

            if ($digito == 10) {
                $digito = 0;
            }

            return $digito;
        } elseif ($resto == 1) {
            $resto = $soma % 11;

            return $resto;
        }
    }
}