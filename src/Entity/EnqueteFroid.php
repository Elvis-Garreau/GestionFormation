<?php

namespace App\Entity;

use App\Repository\EnqueteChaudRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnqueteFroidRepository::class)
 */
class EnqueteFroid
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
    private $duree_stage;

    /**
     * @ORM\Column(type="integer")
     */
    private $support_formation;

    /**
     * @ORM\Column(type="integer")
     */
    private $formateur_clair;

    /**
     * @ORM\Column(type="integer")
     */
    private $formateur_adapte;

    /**
     * @ORM\Column(type="integer")
     */
    private $programme_clair;

    /**
     * @ORM\Column(type="integer")
     */
    private $programme_adapte;

    /**
     * @ORM\Column(type="integer")
     */
    private $objectif_formation;

    /**
     * @ORM\Column(type="integer")
     */
    private $compris_objectif;

    /**
     * @ORM\Column(type="integer")
     */
    private $exercices_pertinents;

    /**
     * @ORM\Column(type="integer")
     */
    private $competences_ameliorees;

    /**
     * @ORM\Column(type="integer")
     */
    private $condition_accueil;

    /**
     * @ORM\Column(type="integer")
     */
    private $apprecie_global;

    /**
     * @ORM\Column(type="boolean")
     */
    private $recommande;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $points_forts;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $points_faibles;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $autres_remarques;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=Planif::class, inversedBy="enqueteFroids")
     */
    private $planif;

    /**
     * @ORM\OneToOne(targetEntity=Stagiaire::class, inversedBy="enqueteFroid", cascade={"persist", "remove"})
     */
    private $stagiaire;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDureeStage(): ?int
    {
        return $this->duree_stage;
    }

    public function setDureeStage(int $duree_stage): self
    {
        $this->duree_stage = $duree_stage;

        return $this;
    }

    public function getSupportFormation(): ?int
    {
        return $this->support_formation;
    }

    public function setSupportFormation(int $support_formation): self
    {
        $this->support_formation = $support_formation;

        return $this;
    }

    public function getFormateurClair(): ?int
    {
        return $this->formateur_clair;
    }

    public function setFormateurClair(int $formateur_clair): self
    {
        $this->formateur_clair = $formateur_clair;

        return $this;
    }

    public function getFormateurAdapte(): ?int
    {
        return $this->formateur_adapte;
    }

    public function setFormateurAdapte(int $formateur_adapte): self
    {
        $this->formateur_adapte = $formateur_adapte;

        return $this;
    }

    public function getProgrammeClair(): ?int
    {
        return $this->programme_clair;
    }

    public function setProgrammeClair(int $programme_clair): self
    {
        $this->programme_clair = $programme_clair;

        return $this;
    }

    public function getProgrammeAdapte(): ?int
    {
        return $this->programme_adapte;
    }

    public function setProgrammeAdapte(int $programme_adapte): self
    {
        $this->programme_adapte = $programme_adapte;

        return $this;
    }

    public function getObjectifFormation(): ?int
    {
        return $this->objectif_formation;
    }

    public function setObjectifFormation(int $objectif_formation): self
    {
        $this->objectif_formation = $objectif_formation;

        return $this;
    }

    public function getComprisObjectif(): ?int
    {
        return $this->compris_objectif;
    }

    public function setComprisObjectif(int $compris_objectif): self
    {
        $this->compris_objectif = $compris_objectif;

        return $this;
    }

    public function getExercicesPertinents(): ?int
    {
        return $this->exercices_pertinents;
    }

    public function setExercicesPertinents(int $exercices_pertinents): self
    {
        $this->exercices_pertinents = $exercices_pertinents;

        return $this;
    }

    public function getCompetencesAmeliorees(): ?int
    {
        return $this->competences_ameliorees;
    }

    public function setCompetencesAmeliorees(int $competences_ameliorees): self
    {
        $this->competences_ameliorees = $competences_ameliorees;

        return $this;
    }

    public function getConditionAccueil(): ?int
    {
        return $this->condition_accueil;
    }

    public function setConditionAccueil(int $condition_accueil): self
    {
        $this->condition_accueil = $condition_accueil;

        return $this;
    }

    public function getApprecieGlobal(): ?int
    {
        return $this->apprecie_global;
    }

    public function setApprecieGlobal(int $apprecie_global): self
    {
        $this->apprecie_global = $apprecie_global;

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

    public function getPointsForts(): ?string
    {
        return $this->points_forts;
    }

    public function setPointsForts(?string $points_forts): self
    {
        $this->points_forts = $points_forts;

        return $this;
    }

    public function getPointsFaibles(): ?string
    {
        return $this->points_faibles;
    }

    public function setPointsFaibles(?string $points_faibles): self
    {
        $this->points_faibles = $points_faibles;

        return $this;
    }

    public function getAutresRemarques(): ?string
    {
        return $this->autres_remarques;
    }

    public function setAutresRemarques(?string $autres_remarques): self
    {
        $this->autres_remarques = $autres_remarques;

        return $this;
    }

    public function getDocAttestationPresence(): ?bool
    {
        return $this->doc_attestation_presence;
    }

    public function setDocAttestationPresence(bool $doc_attestation_presence): self
    {
        $this->doc_attestation_presence = $doc_attestation_presence;

        return $this;
    }

    public function getDocProgramme(): ?bool
    {
        return $this->doc_programme;
    }

    public function setDocProgramme(bool $doc_programme): self
    {
        $this->doc_programme = $doc_programme;

        return $this;
    }

    public function getDocProcedureEvaluation(): ?bool
    {
        return $this->doc_procedure_evaluation;
    }

    public function setDocProcedureEvaluation(bool $doc_procedure_evaluation): self
    {
        $this->doc_procedure_evaluation = $doc_procedure_evaluation;

        return $this;
    }

    public function getDocConvocation(): ?bool
    {
        return $this->doc_convocation;
    }

    public function setDocConvocation(bool $doc_convocation): self
    {
        $this->doc_convocation = $doc_convocation;

        return $this;
    }

    public function getDocReglement(): ?bool
    {
        return $this->doc_reglement;
    }

    public function setDocReglement(bool $doc_reglement): self
    {
        $this->doc_reglement = $doc_reglement;

        return $this;
    }

    public function getDocBailLocation(): ?bool
    {
        return $this->doc_bail_location;
    }

    public function setDocBailLocation(bool $doc_bail_location): self
    {
        $this->doc_bail_location = $doc_bail_location;

        return $this;
    }

    public function getDocPlan(): ?bool
    {
        return $this->doc_plan;
    }

    public function setDocPlan(bool $doc_plan): self
    {
        $this->doc_plan = $doc_plan;

        return $this;
    }

    public function getDocOrganigrammeOf(): ?bool
    {
        return $this->doc_organigramme_of;
    }

    public function setDocOrganigrammeOf(bool $doc_organigramme_of): self
    {
        $this->doc_organigramme_of = $doc_organigramme_of;

        return $this;
    }

    public function getDocDocumentUnique(): ?bool
    {
        return $this->doc_document_unique;
    }

    public function setDocDocumentUnique(bool $doc_document_unique): self
    {
        $this->doc_document_unique = $doc_document_unique;

        return $this;
    }

    public function getDocVeilles(): ?bool
    {
        return $this->doc_veilles;
    }

    public function setDocVeilles(bool $doc_veilles): self
    {
        $this->doc_veilles = $doc_veilles;

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

    public function getPlanif(): ?Planif
    {
        return $this->planif;
    }

    public function setPlanif(?Planif $planif): self
    {
        $this->planif = $planif;

        return $this;
    }

    public function getStagiaire(): ?Stagiaire
    {
        return $this->stagiaire;
    }

    public function setStagiaire(?Stagiaire $stagiaire): self
    {
        $this->stagiaire = $stagiaire;

        return $this;
    }
}
