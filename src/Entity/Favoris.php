<?php

namespace App\Entity;

use App\Repository\FavorisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavorisRepository::class)]
class Favoris
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'favoris')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateurs $id_U = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Hackatons $id_H = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdU(): ?Utilisateurs
    {
        return $this->id_U;
    }

    public function setIdU(?Utilisateurs $id_U): self
    {
        $this->id_U = $id_U;

        return $this;
    }

    public function getIdH(): ?Hackatons
    {
        return $this->id_H;
    }

    public function setIdH(?Hackatons $id_H): self
    {
        $this->id_H = $id_H;

        return $this;
    }
}
