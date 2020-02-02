<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParticiperRepository")
 */
class Participer
{

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Brocante", inversedBy="participers")
     * @ORM\JoinColumn(name="id_brocante", referencedColumnName="id_brocante")
     */
    private $id_brocante;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="participers")
     * @ORM\JoinColumn(name="id_utilisateur", referencedColumnName="id_utilisateur")
     */
    private $id_utilisateur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role_brocante;


    public function getIdBrocante(): ?Brocante
    {
        return $this->id_brocante;
    }

    public function setIdBrocante(?Brocante $id_brocante): self
    {
        $this->id_brocante = $id_brocante;

        return $this;
    }

    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->id_utilisateur;
    }

    public function setIdUtilisateur(?Utilisateur $id_utilisateur): self
    {
        $this->id_utilisateur = $id_utilisateur;

        return $this;
    }

    public function getRoleBrocante(): ?string
    {
        return $this->role_brocante;
    }

    public function setRoleBrocante(string $role_brocante): self
    {
        $this->role_brocante = $role_brocante;

        return $this;
    }
}
