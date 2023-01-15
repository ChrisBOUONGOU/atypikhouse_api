<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Enum\OfferCommentStatus;
use App\Repository\OfferCommentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Validator\CanPostComment;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: OfferCommentRepository::class)]
#[CanPostComment]
#[ApiResource(
    normalizationContext: ['groups' => ['offerComment:read']],
    denormalizationContext: ['groups' => ['offerComment:write']],
    paginationItemsPerPage: 9,
    order: ['id' => "DESC"]
)]
#[ApiFilter(SearchFilter::class, properties: ["offer" => "exact", "client" => "exact", "status" => "exact"])]
class OfferComment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['offerComment:read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['offerComment:read', 'offerComment:write'])]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'offerComments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['offerComment:read', 'offerComment:write'])]
    #[Assert\NotNull]
    private ?Offer $offer = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['offerComment:read', 'offerComment:write'])]
    #[Assert\NotNull]
    private ?User $client = null;

    #[ORM\Column(type: OfferCommentStatus::class)]
    #[Groups(['offerComment:read', 'offerComment:write'])]
    private $status = 'pending';

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

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getStatus(): ?OfferCommentStatus
    {
        return new OfferCommentStatus($this->status);
    }

    public function setStatus(?string $status): self
    {
        $this->status = new OfferCommentStatus($status);

        return $this;
    }
}
