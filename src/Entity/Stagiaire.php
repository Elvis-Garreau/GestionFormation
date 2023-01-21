<?php

namespace App\Entity;

use App\Repository\StagiaireRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=StagiaireRepository::class)
 */
class Stagiaire
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[a-z0-9\.\-\_]*@{1}[a-z0-9\_\-\.]*.[a-z]{2,3}?$/")
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[0-9]{10}$/")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $qualite;

    /**
     * @ORM\ManyToOne(targetEntity=Planif::class, inversedBy="stagiaires")
     */
    private $planif;

    /**
     * @ORM\OneToOne(targetEntity=EnqueteChaud::class, mappedBy="stagiaire", cascade={"persist", "remove"})
     */
    private $enqueteChaud;

    /**
     * @ORM\OneToOne(targetEntity=EnqueteFroid::class, mappedBy="stagiaire", cascade={"persist", "remove"})
     */
    private $enqueteFroid;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function getTelephoneFormated(): string
    {
        $telephone = $this->telephone;

        preg_match( '/([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})$/', $telephone,  $matches );
        $telephone = $matches[1] . ' ' .$matches[2] . ' ' . $matches[3] . ' ' . $matches[4] . ' ' . $matches[5];

        return $telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getQualite(): ?string
    {
        return $this->qualite;
    }

    public function setQualite(string $qualite): self
    {
        $this->qualite = $qualite;

        return $this;
    }

    public function getPlanif(): ?Planif
    {
        return $this->planif;
    }

    public function setPlanif(?Planif $planif): self
    {
        $this->planif = $planif;

        return $this;
    }

    public function getEnqueteChaud(): ?EnqueteChaud
    {
        return $this->enqueteChaud;
    }

    public function setEnqueteChaud(?EnqueteChaud $enqueteChaud): self
    {
        // unset the owning side of the relation if necessary
        if ($enqueteChaud === null && $this->enqueteChaud !== null) {
            $this->enqueteChaud->setStagiaire(null);
        }

        // set the owning side of the relation if necessary
        if ($enqueteChaud !== null && $enqueteChaud->getStagiaire() !== $this) {
            $enqueteChaud->setStagiaire($this);
        }

        $this->enqueteChaud = $enqueteChaud;

        return $this;
    }

    public function getEnqueteFroid(): ?EnqueteFroid
    {
        return $this->enqueteFroid;
    }

    public function setEnqueteFroid(?EnqueteFroid $enqueteFroid): self
    {
        // unset the owning side of the relation if necessary
        if ($enqueteFroid === null && $this->enqueteFroid !== null) {
            $this->enqueteFroid->setStagiaire(null);
        }

        // set the owning side of the relation if necessary
        if ($enqueteFroid !== null && $enqueteFroid->getStagiaire() !== $this) {
            $enqueteFroid->setStagiaire($this);
        }

        $this->enqueteFroid = $enqueteFroid;

        return $this;
    }

    public function getConnectEnquete(): string
    {
        $name = $this->nom . '-' . $this->prenom . '-' . $this->id;

        return $name;
    }
}