<?php

namespace App\Service;

use App\Dto\CreateReportDto;
use App\Entity\WitnessReport;
use App\ValueObject\IpAddress;
use App\ValueObject\Phone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

readonly class WitnessReportService
{
    public function __construct(
        private WitnessReportFileService $witnessReportFileService,
        private CountryResolverService   $countryResolver,
        private FbiApiService            $fbiApiService,
        private EntityManagerInterface   $entityManager
    )
    {}

    public function save(CreateReportDto $createReportDto, string $ipAddress): WitnessReport
    {
        if (!$this->fbiApiService->caseExists($createReportDto->getCaseTitle())) {
            throw new UnprocessableEntityHttpException('Case does not exists');
        }

        $country = $this->countryResolver->resolve($createReportDto->getPhone(), $ipAddress);

        $report = new WitnessReport();
        $report->setName($createReportDto->getName());
        $report->setPhone(new Phone($createReportDto->getPhone()));;
        $report->setIp(new IpAddress($ipAddress));
        $report->setCaseTitle($createReportDto->getCaseTitle());
        $report->setCountry($country);

        $this->witnessReportFileService->saveToFile($report);

        $this->entityManager->persist($report);
        $this->entityManager->flush();

        return $report;
    }

    public function process(WitnessReport $witnessReport): void
    {
        $witnessReport->setIsProcessed(true);
        $this->entityManager->flush();

        $this->witnessReportFileService->processReport($witnessReport);
    }
}
