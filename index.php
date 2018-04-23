<?php

namespace Umbrella\Ya;

require("vendor/autoload.php");


use Umbrella\Ya\RemessaBoleto\Cnab\RemessaFactory;
use Umbrella\Ya\RemessaBoleto\Enum\BancoEnum;


echo "<a href='?banco=" . BancoEnum::BRADESCO ."'>Bradesco</a>";
echo "<br/>";
echo "<a href='?banco=" . BancoEnum::SICOOB . "'>SICOOB</a>";
echo "<hr>";

if (!$_GET['banco']) {return;}

$codigoBanco = $_GET['banco'];


$fileRemessa = (new RemessaFactory())->create(
    # PATH DE ONDE O ARQUIVO VAI SER SALVO
    "/tmp/",
    # ID BANCO
    // BancoEnum::SICOOB,
    $codigoBanco,
    # ARRAY DE DADOS REFERENTE AO ARQUIVO DE REMESSA
    array(
        "dam" => [
            "dam" => 1201076,
            "tipoDocumento" => 2,
            "tipoOrigem" => 2,
            "taxa" => [
                "taxa" => 273,
                "convenioBancario" => [
                    "convenioBancario" => 229,
                    "orgao" => 1707,
                    "carteira" => 23,
                    "convenio" => 4928031,
                    "agencia" => 3739,
                    "digitoAgencia" => 7,
                    "conta" => 16065,
                    "digitoConta" => 2,
                ],
                "valorFixo" => ""
            ],
            "isPago" => "",
            "nossoNumero" => "00000000668",
            "numeroDocumento" => "668",
            "linhaDigitavel" => "23793739019000000006868001606505874730000020000",
            "representacaoNumerica" => "",
            "valor" => "200.00",
            "desconto" => "0.00",
            "multa" => "",
            "juros" => "",
            "correcaoMonetaria" => "0.00",
            "dataEmissao" => "2018-02-22 00:00:00",
            "dataVencimento" => "2018-03-24",
            "baixa" => "",
        ],
        "pagador" => [
            "pessoa" => 3723770,
            "municipio" => 6001,
            "nome" => "SERGIO HAELTON DE OLIVEIRA GIL",
            "cpfCnpj" => "59314788768",
            "identidade" => "038498234",
            "orgaoEmissor" => "SSP",
            "ufEmissor" => 100133,
            "dtEmissao" => "",
            "dtNascimento" => "1959-01-28",
            "sexo" => "M",
            "mae" => "",
            "pai" => "",
            "nacionalidade" => 105,
            "endereco" => "AVENIDA DAS AMERICAS",
            "numero" => "700",
            "complemento" => "BLOCO 4",
            "bairro" => "BARRA DA TIJUCA",
            "distrito" => "",
            "cep" => "22640100",
            "email" => "WALENCAR@ASAP-DOCUMENTOS.COM.BR",
            "dddTelefone" => "11",
            "telefone" => "33051172",
            "dddFax" => "",
            "fax" => "",
            "dtCadastro" => "2018-02-22 09:18:48",
            "tipoLogradouro" => "",
            "pais" => "",
            "estadoCivil" => "",
            "pessoaJunta" => "",
            "municipioNaturalidade" => "",
            "ufNaturalidade" => "",
            "emancipado" => "",
            "motivoEmancipacao" => "",
            "caixaPostal" => "",
            "ddiTelefone" => "",
            "ddiFax" => "",
            "nire" => "",
            "registroCartorio" => "",
            "anoRegistroCartorio" => "",
            "cartorio" => "",
            "nomeComarca" => "",
            "tipoDocumento" => "",
            "tipoPessoa" => "",
            "passaporte" => ""
        ]
    ));

exit;
