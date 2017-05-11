<?php

namespace Umbrella\Ya\RemessaBoleto;

use Umbrella\Ya\RemessaBoleto\Cnab\Cnab400\Bradesco\File;
use Umbrella\Ya\RemessaBoleto\Cnab\Cnab400\Bradesco\Header;

class RemFactory
{
    protected $savePath;

    public function __construct($savePath = null)
    {
        $this->savePath = $savePath;
    }

    public function build(Header $header, array $transacoes)
    {
        $file = fopen($this->savePath . '/' . (new File())->buildName());
    }
}
