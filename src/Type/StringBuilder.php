<?php

namespace Umbrella\Ya\RemessaBoleto\Type;

class StringBuilder
{
    /**
     * Completa com zeros adicionais à esquerda até o valor informado.
     *
     * @param string $text
     * @param string $length
     * @return string
     */
    public static function zeros($text, $length)
    {
        return str_pad($text, $length, '0', STR_PAD_LEFT);
    }

    /**
     * Completa com espaços adicionais à esquerda até o valor informado.
     *
     * @param string $text
     * @param string $length
     * @return string
     */
    public static function espacos($text, $length)
    {
        return str_pad($text, $length, ' ', STR_PAD_LEFT);
    }
}
