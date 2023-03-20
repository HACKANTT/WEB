<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateInscription = null;

    #[ORM\ManyToOne(inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Hackatons $id_H = null;

    #[ORM\ManyToOne(targetEntity: Utilisateurs::Class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateurs $id_U = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): self
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }
    public function getIdU(): ?Utilisateurs
    {
        return $this->id_U;
    }

    public function setIdU(?Utilisateurs $idU): self
    {
        $this->id_U = $idU;

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
