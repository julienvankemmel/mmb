<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\NotationRepository")
 */
class Notation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numberLike;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numberDislike;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="notation")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BackpackItem", inversedBy="notation")
     */
    private $backpackItem;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Comment", inversedBy="notation")
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", inversedBy="notation")
     */
    private $country;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberLike(): ?int
    {
        return $this->numberLike;
    }

    public function setNumberLike(?int $numberLike): self
    {
        $this->numberLike = $numberLike;

        return $this;
    }

    public function getNumberDislike(): ?int
    {
        return $this->numberDislike;
    }

    public function setNumberDislike(?int $numberDislike): self
    {
        $this->numberDislike = $numberDislike;

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

    public function getBackpackItem(): ?BackpackItem
    {
        return $this->backpackItem;
    }

    public function setBackpackItem(?BackpackItem $backpackItem): self
    {
        $this->backpackItem = $backpackItem;

        return $this;
    }

    public function getComment(): ?Comment
    {
        return $this->comment;
    }

    public function setComment(?Comment $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }
}
