<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\CategoryItemRepository")
 */
class CategoryItem
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
     * @ORM\OneToMany(targetEntity="App\Entity\BackpackItem", mappedBy="categoryItem")
     */
    private $backpackItems;

    public function __construct()
    {
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
            $backpackItem->setCategoryItem($this);
        }

        return $this;
    }

    public function removeBackpackItem(BackpackItem $backpackItem): self
    {
        if ($this->backpackItems->contains($backpackItem)) {
            $this->backpackItems->removeElement($backpackItem);
            // set the owning side to null (unless already changed)
            if ($backpackItem->getCategoryItem() === $this) {
                $backpackItem->setCategoryItem(null);
            }
        }

        return $this;
    }
}
