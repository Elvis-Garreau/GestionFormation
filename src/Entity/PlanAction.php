<?php

namespace App\Entity;

use App\Repository\PlanActionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlanActionRepository::class)
 */
class PlanAction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Planif::class, inversedBy="planAction", cascade={"persist", "remove"})
     */
    private $planif;

    /**
     * @ORM\Column(type="text")
     */
    private $organisation;

    /**
     * @ORM\Column(type="text")
     */
    private $comprehension;

    /**
     * @ORM\Column(type="text")
     */
    private $autre;

    /**
     * @ORM\Column(type="text")
     */
    private $client;

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

    public function getOrganisation(): ?string
    {
        return $this->organisation;
    }

    public function setOrganisation(string $organisation): self
    {
        $this->organisation = $organisation;

        return $this;
    }

    public function getComprehension(): ?string
    {
        return $this->comprehension;
    }

    public function setComprehension(string $comprehension): self
    {
        $this->comprehension = $comprehension;

        return $this;
    }

    public function getAutre(): ?string
    {
        return $this->autre;
    }

    public function setAutre(string $autre): self
    {
        $this->autre = $autre;

        return $this;
    }

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(string $client): self
    {
        $this->client = $client;

        return $this;
    }
}
