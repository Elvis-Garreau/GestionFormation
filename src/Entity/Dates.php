<?php

namespace App\Entity;

use App\Repository\DatesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DatesRepository::class)
 */
class Dates
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Planif::class, inversedBy="dates")
     */
    private $planif;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $date_annee;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $date_mois;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $date_jour;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $heure_debut_matin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $minute_debut_matin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $heure_fin_matin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $minute_fin_matin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $heure_debut_am;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $minute_debut_am;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $heure_fin_am;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $minute_fin_am;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateAnnee(): ?string
    {
        return $this->date_annee;
    }

    public function setDateAnnee(string $date_annee): self
    {
        $this->date_annee = $date_annee;

        return $this;
    }

    public function getDateMois(): ?string
    {
        return $this->date_mois;
    }

    public function setDateMois(string $date_mois): self
    {
        $this->date_mois = $date_mois;

        return $this;
    }

    public function getDateJour(): ?string
    {
        return $this->date_jour;
    }

    public function setDateJour(string $date_jour): self
    {
        $this->date_jour = $date_jour;

        return $this;
    }

    public function getHeureDebutMatin(): ?string
    {
        return $this->heure_debut_matin;
    }

    public function setHeureDebutMatin(string $heure_debut_matin): self
    {
        $this->heure_debut_matin = $heure_debut_matin;

        return $this;
    }

    public function getMinuteDebutMatin(): ?string
    {
        return $this->minute_debut_matin;
    }

    public function setMinuteDebutMatin(string $minute_debut_matin): self
    {
        $this->minute_debut_matin = $minute_debut_matin;

        return $this;
    }

    public function getHeureFinMatin(): ?string
    {
        return $this->heure_fin_matin;
    }

    public function setHeureFinMatin(?string $heure_fin_matin): self
    {
        $this->heure_fin_matin = $heure_fin_matin;

        return $this;
    }

    public function getMinuteFinMatin(): ?string
    {
        return $this->minute_fin_matin;
    }

    public function setMinuteFinMatin(string $minute_fin_matin): self
    {
        $this->minute_fin_matin = $minute_fin_matin;

        return $this;
    }

    public function getHeureDebutAm(): ?string
    {
        return $this->heure_debut_am;
    }

    public function setHeureDebutAm(?string $heure_debut_am): self
    {
        $this->heure_debut_am = $heure_debut_am;

        return $this;
    }

    public function getMinuteDebutAm(): ?string
    {
        return $this->minute_debut_am;
    }

    public function setMinuteDebutAm(?string $minute_debut_am): self
    {
        $this->minute_debut_am = $minute_debut_am;

        return $this;
    }

    public function getHeureFinAm(): ?string
    {
        return $this->heure_fin_am;
    }

    public function setHeureFinAm(?string $heure_fin_am): self
    {
        $this->heure_fin_am = $heure_fin_am;

        return $this;
    }

    public function getMinuteFinAm(): ?string
    {
        return $this->minute_fin_am;
    }

    public function setMinuteFinAm(?string $minute_fin_am): self
    {
        $this->minute_fin_am = $minute_fin_am;

        return $this;
    }
}