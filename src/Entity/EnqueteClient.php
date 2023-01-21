<?php

namespace App\Entity;

use App\Repository\EnqueteClientRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnqueteClientRepository::class)
 */
class EnqueteClient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $offre_disponible;

    /**
     * @ORM\Column(type="integer")
     */
    private $formalites_clair;

    /**
     * @ORM\Column(type="integer")
     */
    private $infos_avant_formation;

    /**
     * @ORM\Column(type="integer")
     */
    private $elements_contractuels;

    /**
     * @ORM\Column(type="integer")
     */
    private $formation_utile_competences;

    /**
     * @ORM\Column(type="integer")
     */
    private $apprecie_relation_of;

    /**
     * @ORM\Column(type="boolean")
     */
    private $recommande;

    /**
     * @ORM\OneToOne(targetEntity=Planif::class, inversedBy="enqueteClient", cascade={"persist", "remove"})
     */
    private $planif;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOffreDisponible(): ?int
    {
        return $this->offre_disponible;
    }

    public function setOffreDisponible(int $offre_disponible): self
    {
        $this->offre_disponible = $offre_disponible;

        return $this;
    }

    public function getFormalitesClair(): ?int
    {
        return $this->formalites_clair;
    }

    public function setFormalitesClair(int $formalites_clair): self
    {
        $this->formalites_clair = $formalites_clair;

        return $this;
    }

    public function getInfosAvantFormation(): ?int
    {
        return $this->infos_avant_formation;
    }

    public function setInfosAvantFormation(int $infos_avant_formation): self
    {
        $this->infos_avant_formation = $infos_avant_formation;

        return $this;
    }

    public function getElementsContractuels(): ?int
    {
        return $this->elements_contractuels;
    }

    public function setElementsContractuels(int $elements_contractuels): self
    {
        $this->elements_contractuels = $elements_contractuels;

        return $this;
    }

    public function getFormationUtileCompetences(): ?int
    {
        return $this->formation_utile_competences;
    }

    public function setFormationUtileCompetences(int $formation_utile_competences): self
    {
        $this->formation_utile_competences = $formation_utile_competences;

        return $this;
    }

    public function getApprecieRelationOf(): ?int
    {
        return $this->apprecie_relation_of;
    }

    public function setApprecieRelationOf(int $apprecie_relation_of): self
    {
        $this->apprecie_relation_of = $apprecie_relation_of;

        return $this;
    }

    public function getRecommande(): ?bool
    {
        return $this->recommande;
    }

    public function setRecommande(bool $recommande): self
    {
        $this->recommande = $recommande;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
