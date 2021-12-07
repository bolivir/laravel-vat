<?php

namespace Bolivir\VAT\Commands;

use Illuminate\Console\Command;

class VATCommand extends Command
{
    public $signature = 'vat';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
