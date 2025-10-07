<?php
declare(strict_types=1);

namespace App\Service;

use libphonenumber\PhoneNumberUtil;
use libphonenumber\NumberParseException;

readonly class PhoneCountryService
{
    private PhoneNumberUtil $phoneNumberUtil;

    public function __construct()
    {
        $this->phoneNumberUtil = PhoneNumberUtil::getInstance();

    }
    /**
     * Try to resolve a country code (ISO alpha-2, e.g. "US", "RS") from phone number.
     */
    public function getCountryFromPhone(string $phoneNumber): ?string
    {
        try {
            $parsed = $this->phoneNumberUtil->parse($phoneNumber);
            $region = $this->phoneNumberUtil->getRegionCodeForNumber($parsed);
            return $region ?: null;
        } catch (NumberParseException $e) {
            return null;
        }
    }
}
