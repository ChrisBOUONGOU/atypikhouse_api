<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\HighlightRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: HighlightRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['highlight:read']],
    denormalizationContext: ['groups' => ['highlight:write']],
)]
class Highlight
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['highlight:read', 'highlight:write'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['highlight:read', 'highlight:write', 'offer:read', 'offer:write'])]
    #[Assert\NotNull]
    #[Assert\Length(min: 10, max: 100)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'highlights')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['highlight:read', 'highlight:write'])]
    #[Assert\NotNull]
    private ?Offer $offer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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
}
