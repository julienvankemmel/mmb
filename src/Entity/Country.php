<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(normalizationContext={"groups"={"backpack:read"}})
 * @ORM\Entity(repositoryClass="App\Repository\CountryRepository")
 */
class Country
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"backpack:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     * @Groups({"backpack:read"})
     * 
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=10)
     * @Groups({"backpack:read"})
     */
    private $alpha2;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $alpha3;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Backpack", mappedBy="country")
     * @Groups({"backpack:read"})
     */
    private $backpacks;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="country")
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Trip", inversedBy="countries")
     */
    private $trip;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Notation", mappedBy="country")
     */
    private $notation;

    public function __construct()
    {
        $this->backpacks = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->trip = new ArrayCollection();
        $this->notation = new ArrayCollection();
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

    public function getAlpha2(): ?string
    {
        return $this->alpha2;
    }

    public function setAlpha2(string $alpha2): self
    {
        $this->name = $alpha2;

        return $this;
    }

    public function getAlpha3(): ?string
    {
        return $this->alpha3;
    }

    public function setAlpha3(string $alpha2): self
    {
        $this->name = $alpha3;

        return $this;
    }


    /**
     * @return Collection|Backpack[]
     */
    public function getBackpacks(): Collection
    {
        return $this->backpacks;
    }

    public function addBackpack(Backpack $backpack): self
    {
        if (!$this->backpacks->contains($backpack)) {
            $this->backpacks[] = $backpack;
            $backpack->addCountry($this);
        }

        return $this;
    }

    public function removeBackpack(Backpack $backpack): self
    {
        if ($this->backpacks->contains($backpack)) {
            $this->backpacks->removeElement($backpack);
            $backpack->removeCountry($this);
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setCountry($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getCountry() === $this) {
                $comment->setCountry(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|trip[]
     */
    public function getTrip(): Collection
    {
        return $this->trip;
    }

    public function addTrip(Trip $trip): self
    {
        if (!$this->trip->contains($trip)) {
            $this->trip[] = $trip;
        }

        return $this;
    }

    public function removeTrip(Trip $trip): self
    {
        if ($this->trip->contains($trip)) {
            $this->trip->removeElement($trip);
        }

        return $this;
    }

    /**
     * @return Collection|notation[]
     */
    public function getNotation(): Collection
    {
        return $this->notation;
    }

    public function addNotation(Notation $notation): self
    {
        if (!$this->notation->contains($notation)) {
            $this->notation[] = $notation;
            $notation->setCountry($this);
        }

        return $this;
    }

    public function removeNotation(Notation $notation): self
    {
        if ($this->notation->contains($notation)) {
            $this->notation->removeElement($notation);
            // set the owning side to null (unless already changed)
            if ($notation->getCountry() === $this) {
                $notation->setCountry(null);
            }
        }

        return $this;
    }
}
