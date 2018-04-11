<?php

namespace Umbrella\Ya\RemessaBoleto\Cnab\Cnab400\SICOOB;

use Umbrella\Ya\RemessaBoleto\Cnab\Generico\FileInterface;

class File implements FileInterface
{
    public function buildName()
    {
        return 'CB' . date('d') . date('m') . 'A1.REM';
    }
}
