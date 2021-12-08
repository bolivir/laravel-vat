<?php

namespace Bolivir\VAT\VIES;

use Bolivir\VAT\Contracts\IClient;
use Bolivir\VAT\Exceptions\VATException;
use SoapClient;
use SoapFault;

class VIES implements IClient
{
    /**
     * @const string
     */
    const URL = 'https://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl';

    private ?SoapClient $client = null;

    protected int $timeout;

    /**
     * @param int $timeout How long should we wait (in seconds) before aborting the request to VIES?
     */
    public function __construct(int $timeout = 10)
    {
        $this->timeout = $timeout;
    }

    /**
     * @throws VATException
     */
    public function checkVAT(string $countryCode, string $vatNumber): bool
    {
        try {
            $response = $this->getClient()->checkVat(
                array(
                    'countryCode' => $countryCode,
                    'vatNumber' => $vatNumber
                )
            );
        } catch (SoapFault $e) {
            throw new VATException($e->getMessage(), $e->getCode());
        }

        return (bool) $response->valid;
    }

    protected function getClient() : SoapClient
    {
        if ($this->client === null) {
            $this->client = new SoapClient(self::URL, ['connection_timeout' => $this->timeout]);
        }

        return $this->client;
    }
}
