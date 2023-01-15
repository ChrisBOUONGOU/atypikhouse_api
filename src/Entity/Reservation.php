<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use App\Enum\ReservationStatus;
use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Validator\DateRange;
use App\Validator\IsOfferAvailable;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
#[DateRange]
#[IsOfferAvailable]
#[ApiResource(
    normalizationContext: ['groups' => ['reservation:read']],
    denormalizationContext: ['groups' => ['reservation:write']],
    paginationItemsPerPage: 9,
    order: ['id' => "DESC"]
)]
#[ApiFilter(SearchFilter::class, properties: ['status' => 'exact', 'offer' => 'exact', 'client' => 'exact', 'offer.owner.id' => 'exact'])]
#[ApiFilter(DateFilter::class, properties: ['endDate'])]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['reservation:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['reservation:read', 'reservation:write'])]
    #[Assert\NotNull]
    private ?Offer $offer = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['reservation:read', 'reservation:write'])]
    #[Assert\NotNull]
    #[Assert\Type("\DateTimeInterface")]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['reservation:read', 'reservation:write'])]
    #[Assert\NotNull]
    #[Assert\Type("\DateTimeInterface")]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column]
    #[Groups(['reservation:read', 'reservation:write'])]
    #[Assert\NotNull]
    #[Assert\Positive]
    private ?int $unitPrice = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['reservation:read', 'reservation:write'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['reservation:read', 'reservation:write'])]
    private ?\DateTimeInterface $lastModified = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['reservation:read', 'reservation:write'])]
    #[Assert\NotNull]
    private ?User $client = null;

    #[ORM\Column]
    #[Groups(['reservation:read', 'reservation:write'])]
    #[Assert\NotNull]
    #[Assert\Positive]
    private ?int $totalPrice = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['reservation:read', 'reservation:write'])]
    private ?\DateTimeInterface $paymentDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['reservation:read', 'reservation:write'])]
    private ?\DateTimeInterface $cancelDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['reservation:read', 'reservation:write'])]
    private ?string $paymentId = null;

    #[ORM\Column(type: ReservationStatus::class, length: 255)]
    #[Groups(['reservation:read', 'reservation:write'])]
    private $status = 'pending';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOffer(): ?Offer
    {
        return $this->offer;
    }

    public function setOffer(?Offer $offer): self
    {
        $this->offer = $offer;

        return $this;
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

    public function getUnitPrice(): ?int
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(int $unitPrice): self
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getLastModified(): ?\DateTimeInterface
    {
        return $this->lastModified;
    }

    public function setLastModified(?\DateTimeInterface $lastModified): self
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getTotalPrice(): ?int
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(int $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getPaymentDate(): ?\DateTimeInterface
    {
        return $this->paymentDate;
    }

    public function setPaymentDate(?\DateTimeInterface $paymentDate): self
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    public function getCancelDate(): ?\DateTimeInterface
    {
        return $this->cancelDate;
    }

    public function setCancelDate(?\DateTimeInterface $cancelDate): self
    {
        $this->cancelDate = $cancelDate;

        return $this;
    }

    public function getPaymentId(): ?string
    {
        return $this->paymentId;
    }

    public function setPaymentId(?string $paymentId): self
    {
        $this->paymentId = $paymentId;

        return $this;
    }

    public function getStatus(): ?ReservationStatus
    {
        return new ReservationStatus($this->status);
    }

    public function setStatus(?string $status): self
    {
        $this->status = new ReservationStatus($status);

        return $this;
    }
}
