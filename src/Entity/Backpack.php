<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\BackpackRepository")
 */
class Backpack
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastModif;

    /**
     * @ORM\Column(type="datetime")
     */
    private $publishedDate;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="backpack")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Season", inversedBy="backpacks")
     */
    private $season;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategoryBackpack", inversedBy="backpacks")
     */
    private $categoryBackpack;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Trip", inversedBy="backpacks")
     */
    private $trip;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Country", inversedBy="backpacks")
     */
    private $country;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->season = new ArrayCollection();
        $this->trip = new ArrayCollection();
        $this->country = new ArrayCollection();
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

    public function getLastModif(): ?\DateTimeInterface
    {
        return $this->lastModif;
    }

    public function setLastModif(?\DateTimeInterface $lastModif): self
    {
        $this->lastModif = $lastModif;

        return $this;
    }

    public function getPublishedDate(): ?\DateTimeInterface
    {
        return $this->publishedDate;
    }

    public function setPublishedDate(\DateTimeInterface $publishedDate): self
    {
        $this->publishedDate = $publishedDate;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addBackpack($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeBackpack($this);
        }

        return $this;
    }

    /**
     * @return Collection|Season[]
     */
    public function getSeason(): Collection
    {
        return $this->season;
    }

    public function addSeason(Season $season): self
    {
        if (!$this->season->contains($season)) {
            $this->season[] = $season;
        }

        return $this;
    }

    public function removeSeason(season $season): self
    {
        if ($this->season->contains($season)) {
            $this->season->removeElement($season);
        }

        return $this;
    }

    public function getCategoryBackpack(): ?CategoryBackpack
    {
        return $this->categoryBackpack;
    }

    public function setCategoryBackpack(?CategoryBackpack $categoryBackpack): self
    {
        $this->categoryBackpack = $categoryBackpack;

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
     * @return Collection|Country[]
     */
    public function getCountry(): Collection
    {
        return $this->country;
    }

    public function addCountry(Country $country): self
    {
        if (!$this->country->contains($country)) {
            $this->country[] = $country;
        }

        return $this;
    }

    public function removeCountry(Country $country): self
    {
        if ($this->country->contains($country)) {
            $this->country->removeElement($country);
        }

        return $this;
    }
}
