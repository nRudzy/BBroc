<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlaceRepository")
 */
class Place
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Emplacement", inversedBy="places", cascade={"persist"})
     * @ORM\JoinColumn(name="id_emplacement", referencedColumnName="id_emplacement")
     */
    private $id_emplacement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Brocante", inversedBy="places", cascade={"persist"})
     * @ORM\JoinColumn(name="id_brocante", referencedColumnName="id_brocante")
     */
    private $id_brocante;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="boolean")
     */
    private $disponible;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="places")
     * @ORM\JoinColumn(name="utilisateur", referencedColumnName="id_utilisateur")
     */
    private $utilisateur;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEmplacement(): ?Emplacement
    {
        return $this->id_emplacement;
    }

    public function setIdEmplacement(?Emplacement $id_emplacement): self
    {
        $this->id_emplacement = $id_emplacement;

        return $this;
    }

    public function getIdBrocante(): ?Brocante
    {
        return $this->id_brocante;
    }

    public function setIdBrocante(?Brocante $id_brocante): self
    {
        $this->id_brocante = $id_brocante;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDisponible(): ?bool
    {
        return $this->disponible;
    }

    public function setDisponible(bool $disponible): self
    {
        $this->disponible = $disponible;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
}
