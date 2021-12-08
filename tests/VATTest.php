<?php

use Bolivir\VAT\Facades\VAT;

it('can validate the formats correctly', function () {
    $valid = [
        'ATU12345678',
        'BE0123456789',
        'BE1234567891',
        'BG123456789',
        'BG1234567890',
        'CY12345678X',
        'CZ12345678',
        'DE123456789',
        'DK12345678',
        'EE123456789',
        'EL123456789',
        'ESX12345678',
        'FI12345678',
        'FR12345678901',
        'FRA2345678901',
        'FRAB345678901',
        'FR1B345678901',
        'GB999999973',
        'HU12345678',
        'HR12345678901',
        'IE1234567X',
        'IT12345678901',
        'LT123456789',
        'LU12345678',
        'LV12345678901',
        'MT12345678',
        'NL123456789B12',
        'PL1234567890',
        'PT123456789',
        'RO123456789',
    ];

    $invalid = [
        '',
        'ATU1234567',
        'BE012345678',
        'BE123456789',
        'BG1234567',
        'CY1234567X',
        'CZ1234567',
        'DE12345678',
        'PREFIX_NL12345678B12',
        'NL12345678B12_SUFFIX',
    ];

    foreach ($valid as $format) {
        expect(VAT::validateFormat($format))->toBeTrue();
    }

    foreach ($invalid as $format) {
        expect(VAT::validateFormat($format))->toBeFalse();
    }
});

it('can validate the existence', function () {
    expect(VAT::validateExistence('BE0123456789'))->toBeFalse();
});

it('can check the format and existence', function () {
    expect(VAT::validate('BE0123456789'))->toBeFalse();
});
