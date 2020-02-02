<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BrocanteRepository")
 */
class Brocante
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id_brocante;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="2", max="255")
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Place", mappedBy="id_brocante", cascade={"remove"})
     */
    private $places;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Participer", mappedBy="id_brocante", cascade={"remove"})
     */
    private $participers;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * Base64 of the image
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $rue;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Villesfr", inversedBy="brocantes")
     * @ORM\JoinColumn(name="lieu", referencedColumnName="ville_id")
     */
    private $lieu;

    /**
     * @ORM\Column(type="float", nullable=true, options={ "default" : 0})
     */
    private $prix; // 0 par défault

    /**
     * @ORM\Column(type="boolean", options={ "default" : false})
     */
    private $suggestion; // false par défaut


    public function __construct()
    {
        $this->places = new ArrayCollection();
        $this->participers = new ArrayCollection();
    }


    public function getIdBrocante(): ?int
    {
        return $this->id_brocante;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
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
            $place->setIdBrocante($this);
        }

        return $this;
    }

    public function removePlace(Place $place): self
    {
        if ($this->places->contains($place)) {
            $this->places->removeElement($place);
            // set the owning side to null (unless already changed)
            if ($place->getIdBrocante() === $this) {
                $place->setIdBrocante(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Participer[]
     */
    public function getParticipers(): Collection
    {
        return $this->participers;
    }

    public function addParticiper(Participer $participer): self
    {
        if (!$this->participers->contains($participer)) {
            $this->participers[] = $participer;
            $participer->setIdBrocante($this);
        }

        return $this;
    }

    public function removeParticiper(Participer $participer): self
    {
        if ($this->participers->contains($participer)) {
            $this->participers->removeElement($participer);
            // set the owning side to null (unless already changed)
            if ($participer->getIdBrocante() === $this) {
                $participer->setIdBrocante(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getLieu(): ?Villesfr
    {
        return $this->lieu;
    }

    public function setLieu(?Villesfr $lieu): self
    {
        $this->lieu = $lieu;

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

    public function getSuggestion(): ?bool
    {
        return $this->suggestion;
    }

    public function setSuggestion(bool $suggestion): self
    {
        $this->suggestion = $suggestion;

        return $this;
    }
}
