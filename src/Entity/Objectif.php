<?php

namespace App\Entity;

use App\Repository\ObjectifRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ObjectifRepository::class)
 */
class Objectif
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $nom_objectif;

    /**
     * @ORM\ManyToOne(targetEntity=Formation::class, inversedBy="objectifs")
     */
    private $formation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomObjectif(): ?string
    {
        return $this->nom_objectif;
    }

    public function setNomObjectif(string $nom_objectif): self
    {
        $this->nom_objectif = $nom_objectif;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;

        return $this;
    }
    
}
