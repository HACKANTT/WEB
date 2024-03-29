<?php

namespace App\Entity;

use App\Repository\InscritsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscritsRepository::class)]
class Inscrits
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'inscrits')]
     #[ORM\JoinColumn(name: 'atelier', referencedColumnName: 'id')]
    private ?Atelier $relationAtelier = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRelationAtelier(): ?Atelier
    {
        return $this->relationAtelier;
    }

    public function setRelationAtelier(?Atelier $relationAtelier): self
    {
        $this->relationAtelier = $relationAtelier;

        return $this;
    }
}
