<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use App\Repository\OfferTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: OfferTypeRepository::class)]
#[ApiFilter(BooleanFilter::class, properties: ["isTrending"])]
#[UniqueEntity("name")]
#[ApiResource(
    normalizationContext: ['groups' => ['offerType:read']],
    denormalizationContext: ['groups' => ['offerType:write']],
    attributes: ["pagination_client_enabled" => true],
    paginationItemsPerPage: 9
)]
class OfferType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['offerType:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['offerType:read', 'offerType:write'])]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['offerType:read', 'offerType:write'])]
    private ?bool $isTrending = null;

    #[ORM\Column(length: 255)]
    #[Groups(['offerType:read', 'offerType:write'])]
    private ?string $imageUrl = null;

    #[ORM\OneToMany(mappedBy: 'offerType', targetEntity: Offer::class)]
    private Collection $offers;

    #[ORM\OneToMany(mappedBy: 'offerType', targetEntity: DynamicProperty::class)]
    #[Groups(['offerType:read'])]
    private Collection $dynamicProperties;

    public function __construct()
    {
        $this->offers = new ArrayCollection();
        $this->dynamicProperties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function isIsTrending(): ?bool
    {
        return $this->isTrending;
    }

    public function setIsTrending(?bool $isTrending): self
    {
        $this->isTrending = $isTrending;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * @return Collection<int, Offer>
     */
    public function getOffers(): Collection
    {
        return $this->offers;
    }

    public function addOffer(Offer $offer): self
    {
        if (!$this->offers->contains($offer)) {
            $this->offers->add($offer);
            $offer->setOfferType($this);
        }

        return $this;
    }

    public function removeOffer(Offer $offer): self
    {
        if ($this->offers->removeElement($offer)) {
            // set the owning side to null (unless already changed)
            if ($offer->getOfferType() === $this) {
                $offer->setOfferType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DynamicProperty>
     */
    public function getDynamicProperties(): Collection
    {
        return $this->dynamicProperties;
    }

    public function addDynamicProperty(DynamicProperty $dynamicProperty): self
    {
        if (!$this->dynamicProperties->contains($dynamicProperty)) {
            $this->dynamicProperties->add($dynamicProperty);
            $dynamicProperty->setOfferType($this);
        }

        return $this;
    }

    public function removeDynamicProperty(DynamicProperty $dynamicProperty): self
    {
        if ($this->dynamicProperties->removeElement($dynamicProperty)) {
            // set the owning side to null (unless already changed)
            if ($dynamicProperty->getOfferType() === $this) {
                $dynamicProperty->setOfferType(null);
            }
        }

        return $this;
    }
}
