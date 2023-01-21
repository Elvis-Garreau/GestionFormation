<?php

namespace App\Entity;

use App\Repository\PlanifRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PlanifRepository::class)
 */
class Planif
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Formation::class, inversedBy="planifs")
     */
    private $programme;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="planifs")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=Formateur::class, inversedBy="planifs")
     */
    private $formateur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[0-9]{5}$/")
     */
    private $code_postal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $salle;

    /**
     * @ORM\OneToMany(targetEntity=Stagiaire::class, mappedBy="planif", cascade={"persist", "remove"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $stagiaires;

    /**
     * @ORM\ManyToOne(targetEntity=Organisme::class, inversedBy="planifs")
     */
    private $organisme;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[0-9]*$/")
     */
    private $prix;

    /**
     * @ORM\OneToMany(targetEntity=Dates::class, mappedBy="planif", cascade={"persist", "remove"})
     * #ORM\JoinColumn(onDelete="CASCADE")
     */
    private $dates;

    /**
     * @ORM\OneToMany(targetEntity=EnqueteChaud::class, mappedBy="planif")
     */
    private $enqueteChauds;

    /**
     * @ORM\OneToMany(targetEntity=EnqueteFroid::class, mappedBy="planif")
     */
    private $enqueteFroids;

    /**
     * @ORM\OneToOne(targetEntity=EnqueteClient::class, mappedBy="planif", cascade={"persist", "remove"})
     */
    private $enqueteClient;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $modalite_orga;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $date_debut;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $date_fin;

    /**
     * @ORM\OneToOne(targetEntity=PlanAction::class, mappedBy="planif", cascade={"persist", "remove"})
     */
    private $planAction;

    public function __construct()
    {
        $this->stagiaires = new ArrayCollection();
        $this->dates = new ArrayCollection();
        $this->enqueteChauds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProgramme(): ?Formation
    {
        return $this->programme;
    }

    public function setProgramme(?Formation $programme): self
    {
        $this->programme = $programme;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getFormateur(): ?Formateur
    {
        return $this->formateur;
    }

    public function setFormateur(?Formateur $formateur): self
    {
        $this->formateur = $formateur;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getEtage(): ?string
    {
        return $this->etage;
    }

    public function setEtage(string $etage): self
    {
        $this->etage = $etage;

        return $this;
    }

    public function getSalle(): ?string
    {
        return $this->salle;
    }

    public function setSalle(string $salle): self
    {
        $this->salle = $salle;

        return $this;
    }

    /**
     * @return Collection|Stagiaire[]
     */
    public function getStagiaires(): Collection
    {
        return $this->stagiaires;
    }

    public function addStagiaire(Stagiaire $stagiaire): self
    {
        if (!$this->stagiaires->contains($stagiaire)) {
            $this->stagiaires[] = $stagiaire;
            $stagiaire->setPlanif($this);
        }

        $this->stagiaires->add($stagiaire);

        return $this;
    }

    public function removeStagiaire(Stagiaire $stagiaire): self
    {
        if ($this->stagiaires->removeElement($stagiaire)) {
            // set the owning side to null (unless already changed)
            if ($stagiaire->getPlanif() === $this) {
                $stagiaire->setPlanif(null);
            }
        }

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

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection|Dates[]
     */
    public function getDates(): Collection
    {
        return $this->dates;
    }

    public function addDate(Dates $date): self
    {
        if (!$this->dates->contains($date)) {
            $this->dates[] = $date;
            $date->setPlanif($this);
        }

        $this->dates->add($date);

        return $this;
    }

    public function removeDate(Dates $date): self
    {
        if ($this->dates->removeElement($date)) {
            // set the owning side to null (unless already changed)
            if ($date->getPlanif() === $this) {
                $date->setPlanif(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EnqueteChaud[]
     */
    public function getEnqueteChauds(): Collection
    {
        return $this->enqueteChauds;
    }

    public function addEnqueteChaud(EnqueteChaud $enqueteChaud): self
    {
        if (!$this->enqueteChauds->contains($enqueteChaud)) {
            $this->enqueteChauds[] = $enqueteChaud;
            $enqueteChaud->setPlanif($this);
        }

        return $this;
    }

    public function removeEnqueteChaud(EnqueteChaud $enqueteChaud): self
    {
        if ($this->enqueteChauds->removeElement($enqueteChaud)) {
            // set the owning side to null (unless already changed)
            if ($enqueteChaud->getPlanif() === $this) {
                $enqueteChaud->setPlanif(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EnqueteFroid[]
     */
    public function getEnqueteFroids(): Collection
    {
        return $this->enqueteFroids;
    }

    public function addEnqueteFroid(EnqueteFroid $enqueteFroid): self
    {
        if (!$this->enqueteFroids->contains($enqueteFroid)) {
            $this->enqueteFroids[] = $enqueteFroid;
            $enqueteFroid->setPlanif($this);
        }

        return $this;
    }

    public function removeEnqueteFroid(EnqueteFroid $enqueteFroid): self
    {
        if ($this->enqueteFroids->removeElement($enqueteFroid)) {
            // set the owning side to null (unless already changed)
            if ($enqueteFroid->getPlanif() === $this) {
                $enqueteFroid->setPlanif(null);
            }
        }

        return $this;
    }

    public function getEnqueteClient(): ?EnqueteClient
    {
        return $this->enqueteClient;
    }

    public function setEnqueteClient(?EnqueteClient $enqueteClient): self
    {
        // unset the owning side of the relation if necessary
        if ($enqueteClient === null && $this->enqueteClient !== null) {
            $this->enqueteClient->setPlanif(null);
        }

        // set the owning side of the relation if necessary
        if ($enqueteClient !== null && $enqueteClient->getPlanif() !== $this) {
            $enqueteClient->setPlanif($this);
        }

        $this->enqueteClient = $enqueteClient;

        return $this;
    }

    public function getModaliteOrga(): ?string
    {
        return $this->modalite_orga;
    }

    public function setModaliteOrga(?string $modalite_orga): self
    {
        $this->modalite_orga = $modalite_orga;

        return $this;
    }

    public function getDateDebut(): ?string
    {
        return $this->date_debut;
    }

    public function setDateDebut(string $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?string
    {
        return $this->date_fin;
    }

    public function setDateFin(string $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getPlanAction(): ?PlanAction
    {
        return $this->planAction;
    }

    public function setPlanAction(?PlanAction $planAction): self
    {
        // unset the owning side of the relation if necessary
        if ($planAction === null && $this->planAction !== null) {
            $this->planAction->setPlanif(null);
        }

        // set the owning side of the relation if necessary
        if ($planAction !== null && $planAction->getPlanif() !== $this) {
            $planAction->setPlanif($this);
        }

        $this->planAction = $planAction;

        return $this;
    }
}
