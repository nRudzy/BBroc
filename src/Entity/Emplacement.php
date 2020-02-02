<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmplacementRepository")
 */
class Emplacement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id_emplacement;

    /**
     * @ORM\Column(type="integer")
     */
    private $surface;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Place", mappedBy="id_emplacement")
     */
    private $places;

    public function __construct()
    {
        $this->places = new ArrayCollection();
    }


    public function getIdEmplacement(): ?int
    {
        return $this->id_emplacement;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    /**
     * @return Collection|Place[]
     */
    public function getPlaces(): Collection
    {
        return $this->places;
    }

    public function addPlace(Place $place): self
    {
        if (!$this->places->contains($place)) {
            $this->places[] = $place;
            $place->setIdEmplacement($this);
        }

        return $this;
    }

    public function removePlace(Place $place): self
    {
        if ($this->places->contains($place)) {
            $this->places->removeElement($place);
            // set the owning side to null (unless already changed)
            if ($place->getIdEmplacement() === $this) {
                $place->setIdEmplacement(null);
            }
        }

        return $this;
    }


}