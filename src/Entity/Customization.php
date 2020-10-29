<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomizationRepository")
 */
class Customization
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $menuColor;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $cardsColor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="customizations")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMenuColor(): ?string
    {
        return $this->menuColor;
    }

    public function setMenuColor(?string $menuColor): self
    {
        $this->menuColor = $menuColor;

        return $this;
    }

    public function getCardsColor(): ?string
    {
        return $this->cardsColor;
    }

    public function setCardsColor(?string $cardsColor): self
    {
        $this->cardsColor = $cardsColor;

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
}
