<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 */
class Utilisateur implements UserInterface
{
    const DEFAULT_ROLE = "ROLE_USER";
    const ADMIN_ROLE = "ROLE_ADMIN";
    const SUPER_ADMIN_ROLE = "ROLE_SUPER_ADMIN";

    // Duration during which the password hash will be valid
    const RECOVER_PASSWORD_VALIDITY = "+1 hour";

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id_utilisateur;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     *
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, unique=true, nullable=true)
     */
    private $tmp_email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $salt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role = Utilisateur::DEFAULT_ROLE;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=50)
     *
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=50)
     *
     * @ORM\Column(type="string", length=50)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $email_key;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $password_key;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @Gedmo\Timestampable(on="create")
     */
    private $signin_date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $last_login_date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $recover_date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $birth_date;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Participer", mappedBy="id_utilisateur")
     */
    private $participers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Place", mappedBy="utilisateur")
     */
    private $places;


    /**
     * Utilisateur constructor.
     */
    public function __construct()
    {
        $this->salt = sha1(rand());
        $this->participers = new ArrayCollection();
        $this->places = new ArrayCollection();
    }


    /**
     * @return int
     */
    public function getIdUtilisateur(): ?int
    {
        return $this->id_utilisateur;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Utilisateur
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getTmpEmail(): ?string
    {
        return $this->tmp_email;
    }

    /**
     * @param string $tmp_email
     *
     * @return Utilisateur
     */
    public function setTmpEmail(string $tmp_email): self
    {
        $this->tmp_email = $tmp_email;

        return $this;
    }

    /**
     * @param string $password
     *
     * @return Utilisateur
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Generate salt
     *
     * Generate a new salt for the user
     */
    public function generateSalt()
    {
        $this->salt = sha1(rand());
    }

    /**
     * @param string $salt
     *
     * @return Utilisateur
     */
    public function setSalt(string $salt): self
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * @return string
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * @param string $role
     *
     * @return Utilisateur
     */
    public function setRole(string $role): self
    {
        if (null === $role) {
            $this->role = Utilisateur::DEFAULT_ROLE;
        } else {
            $this->role = $role;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     *
     * @return Utilisateur
     */
    public function setNom(string $nom): self
    {
        $this->nom = mb_convert_case($nom, MB_CASE_UPPER);

        return $this;
    }

    /**
     * @return string
     */
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     *
     * @return Utilisateur
     */
    public function setPrenom(string $prenom): self
    {
        $this->prenom = mb_convert_case($prenom, MB_CASE_TITLE);

        return $this;
    }

    /**
     * Generate a new salt for the user
     */
    public function generateEmailKey()
    {
        $this->email_key = sha1(rand());
    }

    /**
     * @return string
     */
    public function getEmailKey(): ?string
    {
        return $this->email_key;
    }

    /**
     * @param string $email_key
     *
     * @return Utilisateur
     */
    public function setEmailKey(?string $email_key): self
    {
        $this->email_key = $email_key;

        return $this;
    }

    /**
     * Generate a new salt for the user
     */
    public function generatePasswordKey()
    {
        $this->password_key = sha1(rand());
        $this->recover_date = new DateTime(self::RECOVER_PASSWORD_VALIDITY);
    }

    /**
     * Check that the email key is correct and still valid
     *
     * @param string $password_key Key to check
     *
     * @return bool
     */
    public function isPasswordKeyValid($password_key)
    {
        return $password_key == $this->password_key && $this->recover_date > new DateTime();
    }

    /**
     * @return string
     */
    public function getPasswordKey(): ?string
    {
        return $this->password_key;
    }

    /**
     * @param string $password_key
     *
     * @return Utilisateur
     */
    public function setPasswordKey(?string $password_key): self
    {
        $this->password_key = $password_key;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getSigninDate(): ?DateTimeInterface
    {
        return $this->signin_date;
    }

    /**
     * @param DateTimeInterface $signin_date
     *
     * @return Utilisateur
     */
    public function setSigninDate(?DateTimeInterface $signin_date): self
    {
        $this->signin_date = $signin_date;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getLastLoginDate(): ?DateTimeInterface
    {
        return $this->last_login_date;
    }

    /**
     * @param DateTimeInterface $last_login_date
     *
     * @return Utilisateur
     */
    public function setLastLoginDate(?DateTimeInterface $last_login_date): self
    {
        $this->last_login_date = $last_login_date;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getRecoverDate(): ?DateTimeInterface
    {
        return $this->recover_date;
    }

    /**
     * @param DateTimeInterface $recover_date
     *
     * @return Utilisateur
     */
    public function setRecoverDate(?DateTimeInterface $recover_date): self
    {
        $this->recover_date = $recover_date;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getBirthDate(): ?DateTimeInterface
    {
        return $this->birth_date;
    }

    /**
     * @param DateTimeInterface $birth_date
     *
     * @return Utilisateur
     */
    public function setBirthDate(DateTimeInterface $birth_date): self
    {
        $this->birth_date = $birth_date;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getParticipers(): Collection
    {
        return $this->participers;
    }

    /**
     * @param Participer $participer
     *
     * @return Utilisateur
     */
    public function addParticiper(Participer $participer): self
    {
        if (!$this->participers->contains($participer)) {
            $this->participers[] = $participer;
            $participer->setIdUtilisateur($this);
        }

        return $this;
    }

    /**
     * @param Participer $participer
     *
     * @return Utilisateur
     */
    public function removeParticiper(Participer $participer): self
    {
        if ($this->participers->contains($participer)) {
            $this->participers->removeElement($participer);
            // set the owning side to null (unless already changed)
            if ($participer->getIdUtilisateur() === $this) {
                $participer->setIdUtilisateur(null);
            }
        }

        return $this;
    }

    /****************** USER INTERFACE ******************/

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return array (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return array($this->role);
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // // There is not sensitive data sava as plain text in this implementation
    }

    /**
     * toString
     *
     * @return string
     */
    public function __toString()
    {
        return $this->nom . ' ' . $this->prenom;
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
            $place->setUtilisateur($this);
        }

        return $this;
    }

    public function removePlace(Place $place): self
    {
        if ($this->places->contains($place)) {
            $this->places->removeElement($place);
            // set the owning side to null (unless already changed)
            if ($place->getUtilisateur() === $this) {
                $place->setUtilisateur(null);
            }
        }

        return $this;
    }
}
