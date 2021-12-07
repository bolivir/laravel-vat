<?php

namespace Bolivir\VAT\VIES;

use Bolivir\VAT\Contracts\IClient;

class VIES implements IClient
{
    public function validate(string $vatNumber): bool
    {
        return false;
    }
}
