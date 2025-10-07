<?php

namespace App\Controller;

use App\Entity\WitnessReport;
use App\Repository\WitnessReportRepository;
use App\Service\WitnessReportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class AgentWitnessReportController extends AbstractController
{
    public function __construct(
        private readonly WitnessReportRepository $reportRepository,
        private readonly SerializerInterface $serializer,
        private readonly WitnessReportService $witnessReportServiceService,
    ) {
    }
    public function index(): JsonResponse
    {
        $reports = $this->reportRepository->findAll();
        $json = $this->serializer->serialize($reports, 'json');

        return new JsonResponse($json, 200, [], true);
    }

    public function show(WitnessReport $witnessReport): JsonResponse
    {
        return new JsonResponse($this->serializer->serialize($witnessReport, 'json'), 200, [], true);
    }

    public function process(WitnessReport $witnessReport): JsonResponse
    {
        $this->witnessReportServiceService->process($witnessReport);
        return $this->json($witnessReport);
    }
}
