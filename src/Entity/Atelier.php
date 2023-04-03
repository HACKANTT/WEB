<?php

namespace App\Entity;

use App\Repository\AtelierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AtelierRepository::class)]
class Atelier extends Evenements
//Atlier est une classe enfant de Evenements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nbParticipants = null;

    #[ORM\OneToMany(mappedBy: 'relationAtelier', targetEntity: Inscrits::class)]
    private Collection $inscrits;
    //On a une collection d'inscrits
    //un atelier peut avoir plusieurs inscrits
    //un inscrit ne peut avoir qu'un seul atelier


    #[ORM\OneToMany(mappedBy: 'id_A', targetEntity: Avis::class, orphanRemoval: true)]
    private Collection $avis;
    //On a une collection d'avis
    //un atelier peut avoir plusieurs avis
    //un avis ne peut avoir qu'un seul atelier

    public function __construct()
    {
        $this->inscrits = new ArrayCollection();
        $this->avis = new ArrayCollection();
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

    /**
     * @return Collection<int, Avis>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): self
    {
        if (!$this->avis->contains($avi)) {
            $this->avis->add($avi);
            $avi->setIdA($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): self
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getIdA() === $this) {
                $avi->setIdA(null);
            }
        }

        return $this;
    }
}
