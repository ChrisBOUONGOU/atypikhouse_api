<?php

namespace App\Entity;

use App\Repository\OfferUnavailabilityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OfferUnavailabilityRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "discr", type: "string")]
#[ORM\DiscriminatorMap(["dayUnavailability" => "DayUnavailability", "exceptionalUnavailability" => "ExceptionalUnavailability"])]
class OfferUnavailability
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['offerUnavailability:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'offerUnavailabilities')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['offerUnavailability:read', 'offerUnavailability:write'])]
    #[Assert\NotNull]
    private ?Offer $offer = null;

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
}
