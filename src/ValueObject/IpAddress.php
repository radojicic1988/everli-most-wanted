<?php

namespace App\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Embeddable]
class IpAddress
{
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'IP address is required.')]
    #[Assert\Ip(message: 'Invalid IP address.')]
    private string $value {
        get {
            return $this->value;
        }
    }

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(IpAddress $other): bool
    {
        return $this->value === $other->value;
    }

    public function getIpAsString(): string
    {
        return (string) $this->value;
    }
}
