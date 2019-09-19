<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SeasonRepository")
 */
class Season
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Backpack", mappedBy="season")
     */
    private $backpacks;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\BackpackItem", mappedBy="season")
     */
    private $backpackItems;

    public function __construct()
    {
        $this->backpacks = new ArrayCollection();
        $this->backpackItems = new ArrayCollection();
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
            $backpack->addSeason($this);
        }

        return $this;
    }

    public function removeBackpack(Backpack $backpack): self
    {
        if ($this->backpacks->contains($backpack)) {
            $this->backpacks->removeElement($backpack);
            $backpack->removeSeason($this);
        }

        return $this;
    }

    /**
     * @return Collection|BackpackItem[]
     */
    public function getBackpackItems(): Collection
    {
        return $this->backpackItems;
    }

    public function addBackpackItem(BackpackItem $backpackItem): self
    {
        if (!$this->backpackItems->contains($backpackItem)) {
            $this->backpackItems[] = $backpackItem;
            $backpackItem->addSeason($this);
        }

        return $this;
    }

    public function removeBackpackItem(BackpackItem $backpackItem): self
    {
        if ($this->backpackItems->contains($backpackItem)) {
            $this->backpackItems->removeElement($backpackItem);
            $backpackItem->removeSeason($this);
        }

        return $this;
    }
}
