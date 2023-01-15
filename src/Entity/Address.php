<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['address:read']],
    denormalizationContext: ['groups' => ['address:write']],
)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['address:read', 'offer:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['address:read'])]
    #[Assert\NotBlank(allowNull: true)]
    private ?string $latitude = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['address:read'])]
    #[Assert\NotBlank(allowNull: true)]
    private ?string $longitude = null;

    #[ORM\Column(length: 255)]
    #[Groups(['offer:write', 'address:read'])]
    #[Assert\Regex(pattern: "/^([A-zÀ-ÿ0-9\s\-']+)$/")]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Length(min: 5, max: 60)]
    private ?string $line1 = null;

    #[ORM\Column(length: 20)]
    #[Groups(['offer:write', 'address:read'])]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Regex(pattern: "/^(?:0[1-9]|[1-8]\d|9[0-8])\d{3}$/")]
    private ?string $postalCode = null;

    #[ORM\OneToOne(mappedBy: 'address', cascade: ['persist', 'remove'])]
    #[Groups(['address:read'])]
    private ?Offer $offer = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['address:read', 'offer:read', 'offer:write'])]
    #[Assert\NotNull]
    private ?City $city = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLine1(): ?string
    {
        return $this->line1;
    }

    public function setLine1(string $line1): self
    {
        $this->line1 = $line1;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getOffer(): ?Offer
    {
        return $this->offer;
    }

    public function setOffer(Offer $offer): self
    {
        // set the owning side of the relation if necessary
        if ($offer->getAddress() !== $this) {
            $offer->setAddress($this);
        }

        $this->offer = $offer;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }
}
