<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource(normalizationContext={"groups"={"user:read"}})
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"username"}, message="Ce pseudo est déjà utilisé")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"comment:read"})
     * @Groups({"user:read"})
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     * @Groups({"user:read"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=90, nullable=true)
     * @Groups({"user:read"})
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Groups({"user:read"})
     */
    private $lastName;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"user:read"})
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email(message = "Cet email n'est pas valide.")
     * @Groups({"user:read"})
     */
    private $email;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"user:read"})
     */
    private $avatar;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActif;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Trip", mappedBy="user")
     * @Groups({"user:read"})
     */
    private $trip;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="user")
     * @Groups({"user:read"})
     */
    private $comment;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Notation", mappedBy="user")
     * @Groups({"user:read"})
     */
    private $notation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BackpackItem", mappedBy="user")
     * @Groups({"user:read"})
     */
    private $backpackItem;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Backpack", inversedBy="users")
     * @Groups({"user:read"})
     */
    private $backpack;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\backpack", mappedBy="user")
     */
    private $backpacks;

    public function __construct()
    {
        $this->trip = new ArrayCollection();
        $this->comment = new ArrayCollection();
        $this->notation = new ArrayCollection();
        $this->backpackItem = new ArrayCollection();
        $this->backpack = new ArrayCollection();
        $this->backpacks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

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

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getIsActif(): ?bool
    {
        return $this->isActif;
    }

    public function setIsActif(bool $isActif): self
    {
        $this->isActif = $isActif;

        return $this;
    }

    /**
     * @return Collection|Trip[]
     */
    public function getTrip(): Collection
    {
        return $this->trip;
    }

    public function addTrip(Trip $trip): self
    {
        if (!$this->trip->contains($trip)) {
            $this->trip[] = $trip;
            $trip->setUser($this);
        }

        return $this;
    }

    public function removeTrip(Trip $trip): self
    {
        if ($this->trip->contains($trip)) {
            $this->trip->removeElement($trip);
            // set the owning side to null (unless already changed)
            if ($trip->getUser() === $this) {
                $trip->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComment(): Collection
    {
        return $this->comment;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comment->contains($comment)) {
            $this->comment[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comment->contains($comment)) {
            $this->comment->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Notation[]
     */
    public function getNotation(): Collection
    {
        return $this->notation;
    }

    public function addNotation(Notation $notation): self
    {
        if (!$this->notation->contains($notation)) {
            $this->notation[] = $notation;
            $notation->setUser($this);
        }

        return $this;
    }

    public function removeNotation(Notation $notation): self
    {
        if ($this->notation->contains($notation)) {
            $this->notation->removeElement($notation);
            // set the owning side to null (unless already changed)
            if ($notation->getUser() === $this) {
                $notation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BackpackItem[]
     */
    public function getBackpackItem(): Collection
    {
        return $this->backpackItem;
    }

    public function addBackpackItem(BackpackItem $backpackItem): self
    {
        if (!$this->backpackItem->contains($backpackItem)) {
            $this->backpackItem[] = $backpackItem;
            $backpackItem->setUser($this);
        }

        return $this;
    }

    public function removeBackpackItem(BackpackItem $backpackItem): self
    {
        if ($this->backpackItem->contains($backpackItem)) {
            $this->backpackItem->removeElement($backpackItem);
            // set the owning side to null (unless already changed)
            if ($backpackItem->getUser() === $this) {
                $backpackItem->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Backpack[]
     */
    public function getBackpack(): Collection
    {
        return $this->backpack;
    }

    public function addBackpack(Backpack $backpack): self
    {
        if (!$this->backpack->contains($backpack)) {
            $this->backpack[] = $backpack;
        }

        return $this;
    }

    public function removeBackpack(Backpack $backpack): self
    {
        if ($this->backpack->contains($backpack)) {
            $this->backpack->removeElement($backpack);
        }

        return $this;
    }

    /**
     * @return Collection|backpack[]
     */
    public function getBackpacks(): Collection
    {
        return $this->backpacks;
    }
}
