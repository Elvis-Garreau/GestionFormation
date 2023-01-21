<?php

namespace App\Entity;

use App\Repository\PrerequiRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PrerequiRepository::class)
 */
class Prerequi
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
    private $nom_prerequi;

    /**
     * @ORM\ManyToOne(targetEntity=Formation::class, inversedBy="prerequis")
     */
    private $formation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPrerequi(): ?string
    {
        return $this->nom_prerequi;
    }

    public function setNomPrerequi(string $nom_prerequi): self
    {
        $this->nom_prerequi = $nom_prerequi;

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
