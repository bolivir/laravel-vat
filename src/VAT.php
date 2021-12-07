<?php

namespace Bolivir\VAT;

use Bolivir\VAT\Contracts\IClient;
use Bolivir\VAT\VIES\VIES;

class VAT
{
    /**
     * Regular expression patterns per country code
     *
     * @var array<string, string>
     * @link http://ec.europa.eu/taxation_customs/vies/faq.html?locale=en#item_11
     */
    private $patternExpressions = [
        'AT' => 'U[A-Z\d]{8}',
        'BE' => '(0\d{9}|\d{10})',
        'BG' => '\d{9,10}',
        'CY' => '\d{8}[A-Z]',
        'CZ' => '\d{8,10}',
        'DE' => '\d{9}',
        'DK' => '(\d{2} ?){3}\d{2}',
        'EE' => '\d{9}',
        'EL' => '\d{9}',
        'ES' => '[A-Z]\d{7}[A-Z]|\d{8}[A-Z]|[A-Z]\d{8}',
        'FI' => '\d{8}',
        'FR' => '([A-Z]{2}|\d{2})\d{9}',
        'GB' => '\d{9}|\d{12}|(GD|HA)\d{3}',
        'HR' => '\d{11}',
        'HU' => '\d{8}',
        'IE' => '[A-Z\d]{8}|[A-Z\d]{9}',
        'IT' => '\d{11}',
        'LT' => '(\d{9}|\d{12})',
        'LU' => '\d{8}',
        'LV' => '\d{11}',
        'MT' => '\d{8}',
        'NL' => '\d{9}B\d{2}',
        'PL' => '\d{10}',
        'PT' => '\d{9}',
        'RO' => '\d{2,10}',
        'SE' => '\d{12}',
        'SI' => '\d{8}',
        'SK' => '\d{10}',
    ];

    private IClient $client;

    public function __construct(IClient $client = null)
    {
        if (! $client) {
            $this->client = new VIES();
        } else {
            $this->client = $client;
        }
    }

    /**
     * Validates the given VAT number on format and existence.
     * @param string $vatNumber the full VAT number (incl. country).
     * @return bool
     */
    public function validate(string $vatNumber)
    {
        return $this->validateFormat($vatNumber) && $this->validateExistence($vatNumber);
    }

    /**
     * Validates the given VAT number on format.
     * @param string $vatNumber the full VAT number (incl. country).
     * @return bool
     */
    public function validateFormat(string $vatNumber): bool
    {
        $vatNumber = $this->formatVATString($vatNumber);
        list($country, $number) = $this->splitVATString($vatNumber);

        if (! isset($this->patternExpressions[$country])) {
            return false;
        }

        return preg_match('/^' . $this->patternExpressions[$country] . '$/', $number) > 0;
    }

    /**
     * Format the given vat number to a valid vat number format.
     * It will trim spaces and uppercase the string.
     *
     * @param string $vatNumber the full VAT number (incl. country).
     */
    private function formatVATString(string $vatNumber): string
    {
        return strtoupper(trim($vatNumber));
    }

    /**
     * Get the vat number splitted as country and number
     * @param string $vatNumber
     * @return array<string,string>
     */
    private function splitVATString(string $vatNumber): array
    {
        return [
            substr($vatNumber, 0, 2),
            substr($vatNumber, 2),
        ];
    }
}
