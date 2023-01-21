<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 * @ORM\Table(name="formation", indexes={@ORM\Index(columns={"nom_formation"}, flags={"fulltext"})})
 */
class Formation
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
    private $nom_formation;

    /**
     * @ORM\ManyToOne(targetEntity=Organisme::class, inversedBy="formations")
     */
    private $organisme;

    /**
     * @ORM\OneToMany(targetEntity=ModuleFormation::class, mappedBy="formation", cascade={"persist"})
     */
    private $moduleFormations;

    /**
     * @ORM\OneToMany(targetEntity=Objectif::class, mappedBy="formation", cascade={"persist"})
     */
    private $objectifs;

    /**
     * @ORM\Column(type="text")
     */
    private $public;

    /**
     * @ORM\OneToMany(targetEntity=Prerequi::class, mappedBy="formation", cascade={"persist"})
     */
    private $prerequis;

    /**
     * @ORM\OneToMany(targetEntity=Planif::class, mappedBy="programme")
     */
    private $planifs;

    public function __construct()
    {
        $this->moduleFormations = new ArrayCollection();
        $this->objectifs = new ArrayCollection();
        $this->prerequis = new ArrayCollection();
        $this->planifs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFormation(): ?string
    {
        return $this->nom_formation;
    }

    public function setNomFormation(string $nom_formation): self
    {
        $this->nom_formation = $nom_formation;

        return $this;
    }

    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->nom_formation);
    }

    public function getNomPlusTemps(): string
    {
        $temps = 0;
        foreach ($this->moduleFormations as $module)
        {
            $temps = $temps + $module->getNombreHeure();
        }

        return $this->nom_formation . ' - ' . $temps . 'h';
    }

    public function getOrganisme(): ?organisme
    {
        return $this->organisme;
    }

    public function setOrganisme(?organisme $organisme): self
    {
        $this->organisme = $organisme;

        return $this;
    }

    /**
     * @return Collection|ModuleFormation[]
     */
    public function getModuleFormations(): Collection
    {
        return $this->moduleFormations;
    }

    public function addModuleFormation(ModuleFormation $moduleFormation): self
    {
        if (!$this->moduleFormations->contains($moduleFormation)) {
            $this->moduleFormations[] = $moduleFormation;
            $moduleFormation->setFormation($this);
        }

        $this->moduleFormations->add($moduleFormation);

        return $this;
    }

    public function removeModuleFormation(ModuleFormation $moduleFormation): self
    {
        if ($this->moduleFormations->removeElement($moduleFormation)) {
            // set the owning side to null (unless already changed)
            if ($moduleFormation->getFormation() === $this) {
                $moduleFormation->setFormation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Objectif[]
     */
    public function getObjectifs(): Collection
    {
        return $this->objectifs;
    }

    public function addObjectif(Objectif $objectif): self
    {
        if (!$this->objectifs->contains($objectif)) {
            $this->objectifs[] = $objectif;
            $objectif->setFormation($this);
        }

        $this->objectifs->add($objectif);

        return $this;
    }

    public function removeObjectif(Objectif $objectif): self
    {
        if ($this->objectifs->removeElement($objectif)) {
            // set the owning side to null (unless already changed)
            if ($objectif->getFormation() === $this) {
                $objectif->setFormation(null);
            }
        }

        return $this;
    }

    public function getPublic(): ?string
    {
        return $this->public;
    }

    public function setPublic(string $public): self
    {
        $this->public = $public;

        return $this;
    }

    /**
     * @return Collection|Prerequi[]
     */
    public function getPrerequis(): Collection
    {
        return $this->prerequis;
    }

    public function addPrerequi(Prerequi $prerequi): self
    {
        if (!$this->prerequis->contains($prerequi)) {
            $this->prerequis[] = $prerequi;
            $prerequi->setFormation($this);
        }

        $this->prerequis->add($prerequi);

        return $this;
    }

    public function removePrerequi(Prerequi $prerequi): self
    {
        if ($this->prerequis->removeElement($prerequi)) {
            // set the owning side to null (unless already changed)
            if ($prerequi->getFormation() === $this) {
                $prerequi->setFormation(null);
            }
        }

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
            $planif->setProgramme($this);
        }

        return $this;
    }

    public function removePlanif(Planif $planif): self
    {
        if ($this->planifs->removeElement($planif)) {
            // set the owning side to null (unless already changed)
            if ($planif->getProgramme() === $this) {
                $planif->setProgramme(null);
            }
        }

        return $this;
    }
    
}
