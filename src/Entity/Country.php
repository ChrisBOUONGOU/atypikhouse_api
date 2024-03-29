<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
#[UniqueEntity('name')]
#[ApiResource(
    normalizationContext: ['groups' => ['country:read']],
    denormalizationContext: ['groups' => ['country:write']],
    paginationItemsPerPage: 9
)]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['country:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['country:read', 'country:write', 'address:read'])]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: Region::class)]
    #[Groups(['country:read'])]
    private Collection $regions;

    public function __construct()
    {
        $this->regions = new ArrayCollection();
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

    /**
     * @return Collection<int, Region>
     */
    public function getRegions(): Collection
    {
        return $this->regions;
    }

    public function addRegion(Region $region): self
    {
        if (!$this->regions->contains($region)) {
            $this->regions->add($region);
            $region->setCountry($this);
        }

        return $this;
    }

    public function removeRegion(Region $region): self
    {
        if ($this->regions->removeElement($region)) {
            // set the owning side to null (unless already changed)
            if ($region->getCountry() === $this) {
                $region->setCountry(null);
            }
        }

        return $this;
    }
}
