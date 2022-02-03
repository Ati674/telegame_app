<?php

namespace App\Entity;

use App\Repository\WinnerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WinnerRepository::class)
 */
class Winner
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Tirage::class, inversedBy="winners")
     */
    private $tirage;

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

    public function getTirage(): ?Tirage
    {
        return $this->tirage;
    }

    public function setTirage(?Tirage $tirage): self
    {
        $this->tirage = $tirage;

        return $this;
    }
}
