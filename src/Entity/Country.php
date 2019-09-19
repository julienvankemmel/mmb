<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CountryRepository")
 */
class Country
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Backpack", mappedBy="country")
     */
    private $backpacks;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="country")
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\trip", inversedBy="countries")
     */
    private $trip;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\notation", mappedBy="country")
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

    public function addTrip(trip $trip): self
    {
        if (!$this->trip->contains($trip)) {
            $this->trip[] = $trip;
        }

        return $this;
    }

    public function removeTrip(trip $trip): self
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

    public function addNotation(notation $notation): self
    {
        if (!$this->notation->contains($notation)) {
            $this->notation[] = $notation;
            $notation->setCountry($this);
        }

        return $this;
    }

    public function removeNotation(notation $notation): self
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
