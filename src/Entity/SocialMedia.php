<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SocialMediaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[ORM\Entity(repositoryClass: SocialMediaRepository::class)]
#[UniqueEntity("name")]
#[ApiResource(
    normalizationContext: ['groups' => ['socialMedia:read']],
    denormalizationContext: ['groups' => ['socialMedia:write']],
    paginationItemsPerPage: 9
)]
class SocialMedia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['socialMedia:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['socialMedia:read', 'socialMedia:write'])]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['socialMedia:read', 'socialMedia:write'])]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    private ?string $url = null;

    #[ORM\Column(length: 255)]
    #[Groups(['socialMedia:read', 'socialMedia:write'])]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    private ?string $imageUrl = null;

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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

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
}
