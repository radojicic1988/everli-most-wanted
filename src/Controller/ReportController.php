<?php
declare(strict_types=1);

namespace App\Controller;

use App\Dto\CreateReportDto;
use App\Service\WitnessReportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ReportController extends AbstractController
{

    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly SerializerInterface $serializer,
        private readonly WitnessReportService $witnessReportService,
    ) {

    }

    /**
     * @throws \Exception
     */
    public function create(Request $request): JsonResponse
    {
        $createReportDto = $this->serializer->deserialize($request->getContent(), CreateReportDto::class, 'json');

        $errors = $this->validator->validate($createReportDto);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }

            return $this->json(['errors' => $errorMessages], Response::HTTP_BAD_REQUEST);
        }

        $ipAddress = $request->getClientIp();

        $this->witnessReportService->save($createReportDto, $ipAddress);

        return $this->json(['message' => 'Report saved successfully'], Response::HTTP_CREATED);
    }
}
