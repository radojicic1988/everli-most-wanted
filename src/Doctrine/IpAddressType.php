<?php

namespace App\Doctrine;

use App\ValueObject\IpAddress;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class IpAddressType extends Type
{
    public const NAME = 'ip';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL($column);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof IpAddress ? (string) $value : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value instanceof IpAddress) {
            return $value;
        }

        return new IpAddress($value);
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true; // Important for schema diffing
    }
}
