<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DynamicPropertyUpdateNotificationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DynamicPropertyUpdateNotificationRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['dynamicPropertyUpdateNotification:read']],
    denormalizationContext: ['groups' => ['dynamicPropertyUpdateNotification:write']],
)]
class DynamicPropertyUpdateNotification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['dynamicPropertyUpdateNotification:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['dynamicPropertyUpdateNotification:read', 'dynamicPropertyUpdateNotification:write'])]
    #[Assert\NotNull]
    private ?bool $isSent = null;

    #[ORM\Column]
    #[Groups(['dynamicPropertyUpdateNotification:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['dynamicPropertyUpdateNotification:read', 'dynamicPropertyUpdateNotification:write'])]
    #[Assert\NotNull]
    private ?DynamicProperty $dynamicProperty = null;

    #[ORM\ManyToOne(inversedBy: 'dynamicPropertyUpdateNotifications')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['dynamicPropertyUpdateNotification:read', 'dynamicPropertyUpdateNotification:write'])]
    #[Assert\NotNull]
    private ?User $owner = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsSent(): ?bool
    {
        return $this->isSent;
    }

    public function setIsSent(bool $isSent): self
    {
        $this->isSent = $isSent;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

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

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
