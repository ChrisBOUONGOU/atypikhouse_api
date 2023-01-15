<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ExceptionalUnavailabilityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Validator\DateRange;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExceptionalUnavailabilityRepository::class)]
#[DateRange()]
#[ApiResource(
    normalizationContext: ['groups' => ['offerUnavailability:read']],
    denormalizationContext: ['groups' => ['offerUnavailability:write']],
)]
class ExceptionalUnavailability extends OfferUnavailability
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['offerUnavailability:read', 'offerUnavailability:write'])]
    #[Assert\NotNull]
    #[Assert\Type('\DateTimeInterface')]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['offerUnavailability:read', 'offerUnavailability:write'])]
    #[Assert\NotNull]
    #[Assert\Type('\DateTimeInterface')]
    private ?\DateTimeInterface $endDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }
}
