<?php

namespace App\Service;

readonly class CountryResolverService
{
    public function __construct(
        private PhoneCountryService $phoneCountryService,
        private IpCountryService    $ipCountryService,
    ) {}

    /**
     * Try to resolve a country code (ISO alpha-2, e.g. "US", "RS") from phone number or IP address.
     **/
    public function resolve(?string $phoneNumber, ?string $ipAddress): ?string
    {
        if ($country = $this->phoneCountryService->getCountryFromPhone($phoneNumber)) {
            return $country;
        }

        if ($country = $this->ipCountryService->getCountryFromIp($ipAddress)) {
            return $country;
        }

        throw new \Exception('Unable to determine country');
    }
}
