<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;

use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiFilter(SearchFilter::class, properties: ["email" => "exact"])]
#[UniqueEntity("email")]
#[ApiResource(
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']],
    collectionOperations: [
        'get',
        'post' => ['validation_groups' => ['Default', 'postValidation']]
    ],
    itemOperations: [
        'delete',
        'get',
        'put'
    ],
    paginationItemsPerPage: 9
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read', 'offerComment:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $externalId = null;

    #[ORM\Column(length: 100)]
    #[Groups(['user:read', 'user:write', 'offerComment:read'])]
    #[Assert\Regex(pattern: "/^([A-zÀ-ÿ\s\-']+)$/")]
    #[Assert\NotNull]
    #[Assert\Length(min: 3, max: 100)]
    private ?string $firstName = null;

    #[ORM\Column(length: 100)]
    #[Groups(['user:read', 'user:write', 'offerComment:read'])]
    #[Assert\Regex(pattern: "/^([A-zÀ-ÿ\s\-']+)$/")]
    #[Assert\NotNull]
    #[Assert\Length(min: 3, max: 100)]
    private ?string $lastName = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['user:read', 'user:write'])]
    #[Assert\Type("\DateTimeInterface")]
    private ?\DateTimeInterface $birthdate = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[Groups(['user:write'])]
    #[SerializedName("password")]
    #[Assert\NotNull(groups: ["postValidation"])]
    #[Assert\Length(min: 6)]
    private $plainPassword;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user:read', 'user:write'])]
    #[Assert\Regex(pattern: "/^(\+|00)[0-9]{1,14}$/")]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'user:write'])]
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Email(message: "The email '{{ value }}' is not a valid email.")]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups(['user:read', 'user:write'])]
    #[Assert\NotNull]
    private array $roles = [];



    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: EquipmentUpdateNotification::class)]
    private Collection $equipmentUpdateNotifications;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: DynamicPropertyUpdateNotification::class)]
    private Collection $dynamicPropertyUpdateNotifications;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Offer::class)]
    private Collection $offers;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Reservation::class)]
    private Collection $reservations;

    public function __construct()
    {
        $this->equipmentUpdateNotifications = new ArrayCollection();
        $this->dynamicPropertyUpdateNotifications = new ArrayCollection();
        $this->offers = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setExternalId(string $externalId): self
    {
        $this->externalId = $externalId;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection<int, EquipmentUpdateNotification>
     */
    public function getEquipmentUpdateNotifications(): Collection
    {
        return $this->equipmentUpdateNotifications;
    }

    public function addEquipmentUpdateNotification(EquipmentUpdateNotification $equipmentUpdateNotification): self
    {
        if (!$this->equipmentUpdateNotifications->contains($equipmentUpdateNotification)) {
            $this->equipmentUpdateNotifications->add($equipmentUpdateNotification);
            $equipmentUpdateNotification->setOwner($this);
        }

        return $this;
    }

    public function removeEquipmentUpdateNotification(EquipmentUpdateNotification $equipmentUpdateNotification): self
    {
        if ($this->equipmentUpdateNotifications->removeElement($equipmentUpdateNotification)) {
            // set the owning side to null (unless already changed)
            if ($equipmentUpdateNotification->getOwner() === $this) {
                $equipmentUpdateNotification->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DynamicPropertyUpdateNotification>
     */
    public function getDynamicPropertyUpdateNotifications(): Collection
    {
        return $this->dynamicPropertyUpdateNotifications;
    }

    public function addDynamicPropertyUpdateNotification(DynamicPropertyUpdateNotification $dynamicPropertyUpdateNotification): self
    {
        if (!$this->dynamicPropertyUpdateNotifications->contains($dynamicPropertyUpdateNotification)) {
            $this->dynamicPropertyUpdateNotifications->add($dynamicPropertyUpdateNotification);
            $dynamicPropertyUpdateNotification->setOwner($this);
        }

        return $this;
    }

    public function removeDynamicPropertyUpdateNotification(DynamicPropertyUpdateNotification $dynamicPropertyUpdateNotification): self
    {
        if ($this->dynamicPropertyUpdateNotifications->removeElement($dynamicPropertyUpdateNotification)) {
            // set the owning side to null (unless already changed)
            if ($dynamicPropertyUpdateNotification->getOwner() === $this) {
                $dynamicPropertyUpdateNotification->setOwner(null);
            }
        }

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
            $offer->setOwner($this);
        }

        return $this;
    }

    public function removeOffer(Offer $offer): self
    {
        if ($this->offers->removeElement($offer)) {
            // set the owning side to null (unless already changed)
            if ($offer->getOwner() === $this) {
                $offer->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setClient($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getClient() === $this) {
                $reservation->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * The public representation of the user (e.g. a username, an email address, etc.)
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }
}
