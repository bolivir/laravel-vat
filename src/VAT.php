<?php

namespace Bolivir\VAT;

use Bolivir\VAT\Contracts\IClient;
use Bolivir\VAT\Exceptions\VATException;
use Bolivir\VAT\VIES\VIES;

class VAT
{
    /**
     * Regular expression patterns per country code
     *
     * @var array<string, string>
     * @link http://ec.europa.eu/taxation_customs/vies/faq.html?locale=en#item_11
     */
    private $patterns = [
        'AT' => 'U[A-Z\d]{8}',
        'BE' => '(0\d{9}|\d{10})',
        'BG' => '\d{9,10}',
        'CY' => '\d{8}[A-Z]',
        'CZ' => '\d{8,10}',
        'DE' => '\d{9}',
        'DK' => '(\d{2} ?){3}\d{2}',
        'EE' => '\d{9}',
        'EL' => '\d{9}',
        'ES' => '([A-Z]\d{7}[A-Z]|\d{8}[A-Z]|[A-Z]\d{8})',
        'FI' => '\d{8}',
        'FR' => '[A-Z\d]{2}\d{9}',
        'GB' => '(\d{9}|\d{12}|(GD|HA)\d{3})',
        'HR' => '\d{11}',
        'HU' => '\d{8}',
        'IE' => '([A-Z\d]{8}|[A-Z\d]{9})',
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
        'SK' => '\d{10}'
    ];
    private IClient $client;

    public function __construct(IClient $client = null)
    {
        $this->client = $client ?: new VIES();
    }

    /**
     * Validates the given VAT number on format and existence.
     * @param string $vatNumber the full VAT number (incl. country).
     * @return bool
     */
    public function validate(string $vatNumber): bool
    {
        return $this->validateFormat($vatNumber) && $this->validateExistence($vatNumber);
    }

    /**
     * Validates the existence of the given VAT number via external service
     * @param string $vatNumber the full VAT number (incl. country).
     * @return bool
     */
    public function validateExistence(string $vatNumber): bool
    {
        list($country, $number) = $this->splitVATString($vatNumber);
        $number = $this->formatVATString($number);

        try {
            return $this->client->checkVAT($country, $number);
        } catch (VATException $e) {
            return false;
        }
    }

    /**
     * Validates the given VAT number on format.
     * @param string $vatNumber the full VAT number (incl. country).
     * @return bool
     */
    public function validateFormat(string $vatNumber): bool
    {
        if ($vatNumber === '') {
            return false;
        }

        list($country, $number) = $this->splitVATString($vatNumber);
        $number = $this->formatVATString($number);

        if (! isset($this->patterns[$country])) {
            return false;
        }

        return preg_match('/^' . $this->patterns[$country] . '$/', $number) > 0;
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
     * @return array<string>
     */
    private function splitVATString(string $vatNumber): array
    {
        return [
            substr($vatNumber, 0, 2),
            substr($vatNumber, 2),
        ];
    }
}
