<?php

namespace App\Entity;

use App\Repository\PreuveFormateurRepository;
use Cocur\Slugify\Slugify;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\DateTime;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=PreuveFormateurRepository::class)
 * @Vich\Uploadable()
 */
class PreuveFormateur
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
    private $intitule;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $filename;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="formateur_preuve", fileNameProperty="filename")
     */
    private $preuveFile;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Formateur::class, inversedBy="preuveFormateurs")
     */
    private $formateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getSlug(): string
    {
        $preuveSlug = $this->formateur->getOrganisme()->getNomOf() . '-' . $this->formateur->getSlug() . '-' . $this->intitule;

        return (new Slugify())->slugify($preuveSlug);
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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
     * @return PreuveFormateur
     */
    public function setFilename(?string $filename): PreuveFormateur
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getPreuveFile(): ?File
    {
        return $this->preuveFile;
    }

    /**
     * @param File|null $preuveFile
     * @return PreuveFormateur
     */
    public function setPreuveFile(?File $preuveFile): PreuveFormateur
    {
        $this->preuveFile = $preuveFile;
        if($this->preuveFile instanceof UploadedFile) {
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

    public function getFormateur(): ?Formateur
    {
        return $this->formateur;
    }

    public function setFormateur(?Formateur $formateur): self
    {
        $this->formateur = $formateur;

        return $this;
    }
}
