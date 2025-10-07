<?php

namespace App\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Embeddable]
class Phone
{
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Phone number is required.')]
    #[Assert\Regex(
        pattern: '/^\+?[0-9]{7,15}$/',
        message: 'Invalid phone number format.'
    )]
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

    public function equals(Phone $other): bool
    {
        return $this->value === $other->value;
    }

    public function getPhoneAsString(): string
    {
        return (string) $this->value;
    }

}
