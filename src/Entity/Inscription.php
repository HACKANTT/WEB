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

    #[ORM\Column(length: 255)]
    private ?string $numInscription = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateInscription = null;

    #[ORM\Column]
    private ?int $idH = null;

    #[ORM\Column]
    private ?int $idU = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumInscription(): ?string
    {
        return $this->numInscription;
    }

    public function setNumInscription(string $numInscription): self
    {
        $this->numInscription = $numInscription;

        return $this;
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

    public function getIdH(): ?int
    {
        return $this->idH;
    }

    public function setIdH(int $idH): self
    {
        $this->idH = $idH;

        return $this;
    }

    public function getIdU(): ?int
    {
        return $this->idU;
    }

    public function setIdU(int $idU): self
    {
        $this->idU = $idU;

        return $this;
    }
}
