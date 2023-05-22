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

    #[ORM\OneToMany(mappedBy: 'id_A', targetEntity: Avis::class, orphanRemoval: true)]
    private Collection $avis;

    #[ORM\Column]
    private ?int $nbPlaces = null;
    //On a une collection d'avis
    //un atelier peut avoir plusieurs avis
    //un avis ne peut avoir qu'un seul atelier

    public function __construct()
    {
        $this->avis = new ArrayCollection();
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

    public function getNbPlaces(): ?int
    {
        return $this->nbPlaces;
    }

    public function setNbPlaces(int $nbPlaces): self
    {
        $this->nbPlaces = $nbPlaces;

        return $this;
    }
}
