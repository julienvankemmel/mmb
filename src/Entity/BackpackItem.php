<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(normalizationContext={"groups"={"backpack:read"}})
 * @ORM\Entity(repositoryClass="App\Repository\BackpackItemRepository")
 */
class BackpackItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"backpack:read"})
     * @Groups({"user:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"backpack:read"})
     * @Groups({"user:read"})
     */
    private $buyUrl;

    /**
     * @ORM\Column(type="datetime")
     */
    private $addDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $modifyDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="backpackItem")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Season", inversedBy="backpackItems")
     */
    private $season;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategoryItem", inversedBy="backpackItems")
     * @Groups({"backpack:read"})
     */
    private $categoryItem;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Notation", mappedBy="backpackItem")
     */
    private $notation;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Backpack", mappedBy="backpackitem")
     */
    private $backpacks;

    public function __construct()
    {
        $this->season = new ArrayCollection();
        $this->notation = new ArrayCollection();
        $this->backpacks = new ArrayCollection();
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

    public function getBuyUrl(): ?string
    {
        return $this->buyUrl;
    }

    public function setBuyUrl(?string $buyUrl): self
    {
        $this->buyUrl = $buyUrl;

        return $this;
    }

    public function getAddDate(): ?\DateTimeInterface
    {
        return $this->addDate;
    }

    public function setAddDate(\DateTimeInterface $addDate): self
    {
        $this->addDate = $addDate;

        return $this;
    }

    public function getModifyDate(): ?\DateTimeInterface
    {
        return $this->modifyDate;
    }

    public function setModifyDate(\DateTimeInterface $modifyDate): self
    {
        $this->modifyDate = $modifyDate;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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

    public function removeSeason(Season $season): self
    {
        if ($this->season->contains($season)) {
            $this->season->removeElement($season);
        }

        return $this;
    }

    public function getCategoryItem(): ?CategoryItem
    {
        return $this->categoryItem;
    }

    public function setCategoryItem(?CategoryItem $categoryItem): self
    {
        $this->categoryItem = $categoryItem;

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
            $notation->setBackpackItem($this);
        }

        return $this;
    }

    public function removeNotation(Notation $notation): self
    {
        if ($this->notation->contains($notation)) {
            $this->notation->removeElement($notation);
            // set the owning side to null (unless already changed)
            if ($notation->getBackpackItem() === $this) {
                $notation->setBackpackItem(null);
            }
        }

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
            $backpack->addBackpackitem($this);
        }

        return $this;
    }

    public function removeBackpack(Backpack $backpack): self
    {
        if ($this->backpacks->contains($backpack)) {
            $this->backpacks->removeElement($backpack);
            $backpack->removeBackpackitem($this);
        }

        return $this;
    }
}
