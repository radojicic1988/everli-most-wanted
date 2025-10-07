<?php

namespace App\Service;

use App\Entity\WitnessReport;

class WitnessReportFileService
{
    public function __construct(private readonly string $storagePath)
    {}
    public function saveToFile(WitnessReport $report): void
    {
        if (!file_exists($this->storagePath)) {
            file_put_contents($this->storagePath, json_encode([]));
        }

        $content = file_get_contents($this->storagePath);;
        if ($content) {
            $reports = json_decode($content, true) ?? [];
        }

        $reports[$report->getUuid()->toRfc4122()] = [
            'uuid' => $report->getUuid()->toRfc4122(),
            'name' => $report->getName(),
            'phone' => $report->getPhone()->getPhoneAsString(),
            'caseTitle' => $report->getCaseTitle(),
            'country' => $report->getCountry(),
            'ip' => $report->getIp()->getIpAsString(),
            'createdAt' => (new \DateTimeImmutable())->format(\DateTimeInterface::ATOM),
            'personContacted' => false,
        ];

        file_put_contents($this->storagePath, json_encode($reports, JSON_PRETTY_PRINT));
    }

    public function processReport(WitnessReport $witnessReport): void
    {
        $content = file_get_contents($this->storagePath);
        if ($content) {
            $reports = json_decode($content, true) ?? [];

            if (isset($reports[$witnessReport->getUuid()->toRfc4122()])) {
                $reports[$witnessReport->getUuid()->toRfc4122()]['personContacted'] = true;

                file_put_contents($this->storagePath, json_encode($reports, JSON_PRETTY_PRINT));
            }
        }
    }
}
