<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Enum\DynamicPropertyType;
use App\Repository\DynamicPropertyRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DynamicPropertyRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['dynamicProperty:read']],
    denormalizationContext: ['groups' => ['dynamicProperty:write']],
    attributes: ["pagination_client_enabled" => true],
    paginationItemsPerPage: 9
)]
#[ApiFilter(SearchFilter::class, properties: ["offerType" => "exact"])]
class DynamicProperty
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['dynamicProperty:read', 'dynamicPropertyValue:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['dynamicProperty:read', 'dynamicProperty:write'])]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['dynamicProperty:read', 'dynamicProperty:write'])]
    #[Assert\NotNull]
    private ?bool $isMandatory = null;

    #[ORM\ManyToOne(inversedBy: 'dynamicProperties')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['dynamicProperty:read', 'dynamicProperty:write'])]
    #[Assert\NotNull]
    private ?OfferType $offerType = null;

    #[ORM\Column(type: DynamicPropertyType::class, length: 50)]
    #[Groups(['dynamicProperty:read', 'dynamicProperty:write', 'dynamicPropertyValue:read'])]
    #[Assert\NotNull]
    private $type;

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

    public function getIsMandatory(): ?bool
    {
        return $this->isMandatory;
    }

    public function setIsMandatory(bool $isMandatory): self
    {
        $this->isMandatory = $isMandatory;

        return $this;
    }

    public function getOfferType(): ?OfferType
    {
        return $this->offerType;
    }

    public function setOfferType(?OfferType $offerType): self
    {
        $this->offerType = $offerType;

        return $this;
    }

    public function getType(): ?DynamicPropertyType
    {
        return new DynamicPropertyType($this->type);
    }

    public function setType(string $type): self
    {
        $this->type = new DynamicPropertyType($type);

        return $this;
    }
}
