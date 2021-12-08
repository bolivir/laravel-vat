<?php

namespace Bolivir\VAT\Contracts;

interface IClient
{
    public function checkVAT(string $countryCode, string $vatNumber): bool;
}
