<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[a-z0-9\.\-\_]*@{1}[a-z0-9\_\-]*.[a-z]{2,3}?$/")
     */
    private $email;

    /**
     * @var Organisme
     * @ORM\ManyToOne(targetEntity=Organisme::class, inversedBy="users")
     */
    private $organisme;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="boolean")
     */
    private $role_admin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $roles;

    public function addRoles(string $roles): self
    {
        if(!in_array($roles, $this->roles)){
            $this->roles[] = $roles;
        }

        return $this;
    }

    public function __construct()
    {
        $this->organismes = new ArrayCollection();
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(): self
    {
        $nom = $this->nom;
        $prenom = $this->prenom;

        $this->username = $nom . '-' . $prenom;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getOrganisme(): ?Organisme
    {
        return $this->organisme;
    }

    public function setOrganisme(Organisme $organisme): self
    {
        $this->organisme = $organisme;

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {

    }

    /**
     * @return string|null
     */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password,
            $this->email,
            $this->organisme,
            $this->nom,
            $this->prenom
        ]);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password,
            $this->email,
            $this->organisme,
            $this->nom,
            $this->prenom
            ) = unserialize($serialized, ['allowed_classes' => false]);
    }

    public function getRoleAdmin(): ?bool
    {
        return $this->role_admin;
    }

    public function setRoleAdmin(bool $role_admin): self
    {
        $this->role_admin = $role_admin;

        return $this;
    }

    public function setRoles(string $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        if($this->role_admin){
            $roles = ['ROLE_ADMIN'];
        } else {
            $roles = ['ROLE_USER'];
        }

        return array_unique($roles);
    }

}
