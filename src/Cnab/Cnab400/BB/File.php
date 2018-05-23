<?php

namespace Umbrella\Ya\RemessaBoleto\Cnab\Cnab400\BB;

class File
{
    public function buildName()
    {
        return 'BB-cnab400-' . date('d') . date('m') . 'A1.REM';
    }
}
