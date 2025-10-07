<?php
declare(strict_types=1);

namespace App\Dto;


use App\ValueObject\Phone;
use Symfony\Component\Validator\Constraints as Assert;

class CreateReportDto
{
    #[Assert\NotBlank(message: 'Name is required')]
    #[Assert\Length(min: 2, max: 255)]
    private string $name;

    #[Assert\NotBlank(message: 'Phone number is required')]
    private string $phone;

    #[Assert\NotBlank(message: 'Case title is required')]
    private string $caseTitle;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getPhone(): Phone
    {
        return new Phone($this->phone);
    }

    public function setPhone(string $phone): self
    {
        $this->phone = new Phone($phone);
        return $this;
    }

    public function getCaseTitle(): string
    {
        return $this->caseTitle;
    }

    public function setCaseTitle(string $caseTitle): void
    {
        $this->caseTitle = $caseTitle;
    }
}
