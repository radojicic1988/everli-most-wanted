<?php
declare(strict_types=1);

namespace App\Serializer;

use App\ValueObject\IpAddress;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class IpAddressNormalizer implements NormalizerInterface, DenormalizerInterface
{

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        return new IpAddress($data);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === IpAddress::class;
    }

    public function normalize(mixed $data, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        return (string) $data;
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof IpAddress;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            IpAddress::class => true,
        ];
    }
}
