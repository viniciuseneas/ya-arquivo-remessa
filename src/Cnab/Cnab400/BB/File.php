<?php

namespace Umbrella\Ya\RemessaBoleto\Cnab\Cnab400\CEF;

class File
{
    public function buildName()
    {
        return 'CEF-cnab400-' . date('d') . date('m') . 'A1.REM';
    }
}
