<?php

namespace App\Entity;

use App\Repository\FormateurRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=FormateurRepository::class)
 * @Vich\Uploadable()
 */
class Formateur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $filename;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="formateur_cv", fileNameProperty="filename")
     */
    private $cvFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $formateur_nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $formateur_prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[a-z0-9\.\-\_]*@{1}[a-z0-9\_\-\.]*.[a-z]{2,3}?$/")
     */
    private $formateur_mail;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[0-9]{10}$/")
     */
    private $formateur_phone;

    /**
     * @ORM\ManyToOne(targetEntity=Organisme::class, inversedBy="formateurs")
     */
    private $organisme;

    /**
     * @ORM\OneToMany(targetEntity=Planif::class, mappedBy="formateur")
     */
    private $planifs;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=PreuveFormateur::class, mappedBy="formateur", cascade={"persist", "remove"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $preuveFormateurs;

    public function __construct()
    {
        $this->planifs = new ArrayCollection();
        $this->preuveFormateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFormateurNom(): ?string
    {
        return $this->formateur_nom;
    }

    public function setFormateurNom(string $formateur_nom): self
    {
        $this->formateur_nom = $formateur_nom;

        return $this;
    }

    public function getSlug(): string
    {
        $formateur = $this->formateur_nom . '-' . $this->formateur_prenom;

        return (new Slugify())->slugify($formateur);
    }

    public function getFormateurPrenom(): ?string
    {
        return $this->formateur_prenom;
    }

    public function setFormateurPrenom(string $formateur_prenom): self
    {
        $this->formateur_prenom = $formateur_prenom;

        return $this;
    }

    public function getFormateurMail(): ?string
    {
        return $this->formateur_mail;
    }

    public function setFormateurMail(string $formateur_mail): self
    {
        $this->formateur_mail = $formateur_mail;

        return $this;
    }

    public function getFormateurPhone(): ?string
    {
        return $this->formateur_phone;
    }

    public function getTelephoneFormated():  string
    {
        $telephone = $this->formateur_phone;

        preg_match( '/([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})$/', $telephone,  $matches );
        $telephone = $matches[1] . ' ' .$matches[2] . ' ' . $matches[3] . ' ' . $matches[4] . ' ' . $matches[5];

        return $telephone;
    }

    public function setFormateurPhone(string $formateur_phone): self
    {
        $this->formateur_phone = $formateur_phone;

        return $this;
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
            $planif->setFormateur($this);
        }

        return $this;
    }

    public function removePlanif(Planif $planif): self
    {
        if ($this->planifs->removeElement($planif)) {
            // set the owning side to null (unless already changed)
            if ($planif->getFormateur() === $this) {
                $planif->setFormateur(null);
            }
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @param string|null $filename
     * @return Formateur
     */
    public function setFilename(?string $filename): Formateur
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getCvFile(): ?File
    {
        return $this->cvFile;
    }

    /**
     * @param File|null $cvFile
     * @return Formateur
     */
    public function setCvFile(?File $cvFile): Formateur
    {
        $this->cvFile = $cvFile;
        if($this->cvFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection|PreuveFormateur[]
     */
    public function getPreuveFormateurs(): Collection
    {
        return $this->preuveFormateurs;
    }

    public function addPreuveFormateur(PreuveFormateur $preuveFormateur): self
    {
        if (!$this->preuveFormateurs->contains($preuveFormateur)) {
            $this->preuveFormateurs[] = $preuveFormateur;
            $preuveFormateur->setFormateur($this);
        }

        $this->preuveFormateurs->add($preuveFormateur);

        return $this;
    }

    public function removePreuveFormateur(PreuveFormateur $preuveFormateur): self
    {
        if ($this->preuveFormateurs->removeElement($preuveFormateur)) {
            // set the owning side to null (unless already changed)
            if ($preuveFormateur->getFormateur() === $this) {
                $preuveFormateur->setFormateur(null);
            }
        }

        return $this;
    }

}
