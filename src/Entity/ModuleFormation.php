<?php

namespace App\Entity;

use App\Repository\ModuleFormationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ModuleFormationRepository::class)
 */
class ModuleFormation
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
    private $nom_module;

    /**
     * @ORM\Column(type="float")
     * @Assert\Regex("/^[0-9]+(?:[.,][50]{1})?$/")
     */
    private $nombre_heure;

    /**
     * @ORM\ManyToOne(targetEntity=Formation::class, inversedBy="moduleFormations")
     */
    private $formation;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomModule(): ?string
    {
        return $this->nom_module;
    }

    public function setNomModule(string $nom_module): self
    {
        $this->nom_module = $nom_module;

        return $this;
    }

    public function getNombreHeure(): ?float
    {
        return $this->nombre_heure;
    }

    public function setNombreHeure(float $nombre_heure): self
    {
        $this->nombre_heure = $nombre_heure;

        return $this;
    }

    public function getFormation(): ?formation
    {
        return $this->formation;
    }

    public function setFormation(?formation $formation): self
    {
        $this->formation = $formation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
