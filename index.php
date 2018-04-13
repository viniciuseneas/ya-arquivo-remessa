<?php

namespace Umbrella\Ya;

require("vendor/autoload.php");


use Umbrella\Ya\RemessaBoleto\Cnab\RemessaFactory;
use Umbrella\Ya\RemessaBoleto\Enum\BancoEnum;


$factory = new RemessaFactory();

echo "<a href='?banco=" . BancoEnum::BRADESCO ."'>Bradesco</a>";
echo "<br/>";
echo "<a href='?banco=" . BancoEnum::SICOOB . "'>SICOOB</a>";
echo "<hr>";

if (!$_GET['banco']) {return;}


$codigoBanco = $_GET['banco'];


$factory->create(
    # PATH DE ONDE O ARQUIVO VAI SER SALVO
    "/tmp/remessa",
    # ID BANCO
    // BancoEnum::SICOOB,
    $codigoBanco,
    # ARRAY DE DADOS REFERENTE AO ARQUIVO DE REMESSA
    array(
        "dam" => [
            0 => [
                "carteira"  => "11111111",
                "agencia"   => "11111"
            ],
            1 => [
                "carteira"  => "22222222",
                "agencia"   => "22222"
            ]
        ],
        "pagador" => [
            "ds_nome" => "teste",
            "nu_cpf_cnpj" => "12345678900005"
        ]
    ));


