<?php

namespace App\Service;

use GeoIp2\Database\Reader;

class IpCountryService
{
    private ?Reader $geoIpReader = null;

    public function __construct(?string $geoIpDatabasePath = null)
    {
        if ($geoIpDatabasePath && file_exists($geoIpDatabasePath)) {
            $this->geoIpReader = new Reader($geoIpDatabasePath);
        }
    }

    /**
     * Returns ISO country code (e.g. "US") based on IP.
     */
    public function getCountryFromIp(?string $ip): ?string
    {
        if (!$ip || !$this->geoIpReader) {
            return null;
        }

        try {
            $record = $this->geoIpReader->country($ip);
            return $record->country->isoCode ?? null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
