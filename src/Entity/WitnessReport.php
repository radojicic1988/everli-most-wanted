<?php

namespace App\Entity;

use App\Repository\WitnessReportRepository;
use App\ValueObject\IpAddress;
use App\ValueObject\Phone;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: WitnessReportRepository::class)]
#[ORM\Index(columns: ['uuid'])]
class WitnessReport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private Uuid $uuid;

    #[ORM\Column(type: 'phone', nullable: false)]
    #[ORM\Embedded(class: Phone::class, columnPrefix: false)]
    #[Assert\Valid]
    private Phone $phone;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Name is required.')]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'Name must be at least {{ limit }} characters long.',
        maxMessage: 'Name cannot be longer than {{ limit }} characters.'
    )]
    private string $name;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Case title is required.')]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'Case name must be at least {{ limit }} characters long.',
        maxMessage: 'Case name cannot be longer than {{ limit }} characters.'
    )]
    private string $caseTitle;

    #[ORM\Column(type: 'ip', nullable: false)]
    #[ORM\Embedded(class: IpAddress::class, columnPrefix: false)]
    #[Assert\Valid]
    private IpAddress $ip;

    #[ORM\Column(length: 2)]
    private string $country;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $isProcessed = false;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'processedReports')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?User $processedBy = null;

    public function __construct()
    {
        $this->uuid = Uuid::v7();
        $this->phone = new Phone('');
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }

    public function setPhone(string|Phone $phone): void
    {
        $this->phone = $phone instanceof Phone ? $phone : new Phone($phone);
    }

    public function getIp(): IpAddress
    {
        return $this->ip;
    }

    public function setIp(IpAddress $ip): void
    {
        $this->ip = $ip;
    }

    public function getCaseTitle(): string
    {
        return $this->caseTitle;
    }

    public function setCaseTitle(string $caseTitle): void
    {
        $this->caseTitle = $caseTitle;
    }

    public function isProcessed(): bool
    {
        return $this->isProcessed;
    }

    public function setIsProcessed(bool $isProcessed): void
    {
        $this->isProcessed = $isProcessed;
    }

    public function getProcessedBy(): ?User
    {
        return $this->processedBy;
    }

    public function setProcessedBy(?User $processedBy): void
    {
        $this->processedBy = $processedBy;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }
}
