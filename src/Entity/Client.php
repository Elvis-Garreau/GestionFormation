<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 * @ORM\Table(name="client", indexes={@ORM\Index(columns={"nom_societe", "representant_nom", "representant_prenom"}, flags={"fulltext"})})
 */
class Client
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
    private $nom_societe;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse_rue;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[0-9]{5}$/")
     */
    private $adresse_cp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse_ville;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[0-9]{14}$/")
     */
    private $siret;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $representant_nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $representant_prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[a-z0-9\.\-\_]*@{1}[a-z0-9\_\-\.]*.[a-z]{2,3}?$/")
     */
    private $representant_mail;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[0-9]{10}$/")
     */
    private $representant_telephone;

    /**
     * @ORM\ManyToOne(targetEntity=Organisme::class, inversedBy="clients")
     */
    private $organisme;

    /**
     * @ORM\OneToMany(targetEntity=Planif::class, mappedBy="client")
     */
    private $planifs;

    public function __construct()
    {
        $this->planifs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSociete(): ?string
    {
        return $this->nom_societe;
    }

    public function setNomSociete(string $nom_societe): self
    {
        $this->nom_societe = $nom_societe;

        return $this;
    }

    public function getAdresseRue(): ?string
    {
        return $this->adresse_rue;
    }

    public function setAdresseRue(string $adresse_rue): self
    {
        $this->adresse_rue = $adresse_rue;

        return $this;
    }

    public function getAdresseCp(): ?string
    {
        return $this->adresse_cp;
    }

    public function setAdresseCp(string $adresse_cp): self
    {
        $this->adresse_cp = $adresse_cp;

        return $this;
    }

    public function getAdresseVille(): ?string
    {
        return $this->adresse_ville;
    }

    public function setAdresseVille(string $adresse_ville): self
    {
        $this->adresse_ville = $adresse_ville;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function getSiretFormated(): string
    {
        $siret = $this->siret;

        preg_match( '/([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{5})$/', $siret,  $matches );
        $siretFormated = $matches[1] . ' ' .$matches[2] . ' ' . $matches[3] . ' ' . $matches[4];

        return $siretFormated;
    }

    public function setSiret(string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getRepresentantNom(): ?string
    {
        return $this->representant_nom;
    }

    public function setRepresentantNom(string $representant_nom): self
    {
        $this->representant_nom = $representant_nom;

        return $this;
    }

    public function getRepresentantPrenom(): ?string
    {
        return $this->representant_prenom;
    }

    public function setRepresentantPrenom(string $representant_prenom): self
    {
        $this->representant_prenom = $representant_prenom;

        return $this;
    }

    public function getRepresentantMail(): ?string
    {
        return $this->representant_mail;
    }

    public function setRepresentantMail(string $representant_mail): self
    {
        $this->representant_mail = $representant_mail;

        return $this;
    }

    public function getRepresentantTelephone(): ?string
    {
        return $this->representant_telephone;
    }

    public function getTelephoneFormated(): string
    {
        $telephone = $this->representant_telephone;

        preg_match( '/([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})$/', $telephone,  $matches );
        $telephone = $matches[1] . ' ' .$matches[2] . ' ' . $matches[3] . ' ' . $matches[4] . ' ' . $matches[5];

        return $telephone;
    }

    public function setRepresentantTelephone(string $representant_telephone): self
    {
        $this->representant_telephone = $representant_telephone;

        return $this;
    }

    public function getOrganisme(): ?Organisme
    {
        return $this->organisme;
    }

    public function setOrganisme(?Organisme $organisme): self
    {
        $this->organisme = $organisme;

        return $this;
    }

    /**
     * @return Collection|Planif[]
     */
    public function getPlanifs(): Collection
    {
        return $this->planifs;
    }

    public function addPlanif(Planif $planif): self
    {
        if (!$this->planifs->contains($planif)) {
            $this->planifs[] = $planif;
            $planif->setClient($this);
        }

        return $this;
    }

    public function removePlanif(Planif $planif): self
    {
        if ($this->planifs->removeElement($planif)) {
            // set the owning side to null (unless already changed)
            if ($planif->getClient() === $this) {
                $planif->setClient(null);
            }
        }

        return $this;
    }
}
