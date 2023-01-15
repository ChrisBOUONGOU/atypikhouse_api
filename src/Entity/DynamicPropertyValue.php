<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\DynamicPropertyValueRepository;
use App\Validator\ValidDynamicPropertyValue;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DynamicPropertyValueRepository::class)]
#[ValidDynamicPropertyValue]
#[ApiResource(
    normalizationContext: ['groups' => ['dynamicPropertyValue:read']],
    denormalizationContext: ['groups' => ['dynamicPropertyValue:write']],
    attributes: ["pagination_client_enabled" => true],
)]
#[ApiFilter(SearchFilter::class, properties: ["offer.id" => "exact"])]
class DynamicPropertyValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['dynamicPropertyValue:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['dynamicPropertyValue:read', 'offer:write'])]
    private ?string $value = null;

    #[ORM\ManyToOne(inversedBy: 'dynamicPropertyValues')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['dynamicPropertyValue:read'])]
    #[Assert\NotNull]
    private ?Offer $offer = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    #[Groups(['dynamicPropertyValue:read', 'offer:write'])]
    #[Assert\NotNull]
    private ?DynamicProperty $dynamicProperty = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
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

    public function getDynamicProperty(): ?DynamicProperty
    {
        return $this->dynamicProperty;
    }

    public function setDynamicProperty(?DynamicProperty $dynamicProperty): self
    {
        $this->dynamicProperty = $dynamicProperty;

        return $this;
    }
}
