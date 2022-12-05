<?php

namespace App\Entity;

use App\Repository\AtelierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AtelierRepository::class)]
class Atelier extends Evenements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nbParticipants = null;

    #[ORM\OneToMany(mappedBy: 'relationAtelier', targetEntity: Inscrits::class)]
    private Collection $inscrits;

    public function __construct()
    {
        $this->inscrits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbParticipants(): ?int
    {
        return $this->nbParticipants;
    }

    public function setNbParticipants(int $nbParticipants): self
    {
        $this->nbParticipants = $nbParticipants;

        return $this;
    }

    /**
     * @return Collection<int, Inscrits>
     */
    public function getInscrits(): Collection
    {
        return $this->inscrits;
    }

    public function addInscrit(Inscrits $inscrit): self
    {
        if (!$this->inscrits->contains($inscrit)) {
            $this->inscrits->add($inscrit);
            $inscrit->setRelationAtelier($this);
        }

        return $this;
    }

    public function removeInscrit(Inscrits $inscrit): self
    {
        if ($this->inscrits->removeElement($inscrit)) {
            // set the owning side to null (unless already changed)
            if ($inscrit->getRelationAtelier() === $this) {
                $inscrit->setRelationAtelier(null);
            }
        }

        return $this;
    }
}
