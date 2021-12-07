<?php

namespace Bolivir\VAT\Contracts;

interface IClient
{
    public function validate(string $vatNumber): bool;
}
