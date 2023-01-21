<?php

namespace App\Entity;

use App\Repository\VeilleRepository;
use Cocur\Slugify\Slugify;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\DateTime;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=VeilleRepository::class)
 * @Vich\Uploadable()
 */
class Veille
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
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="organisme_veille", fileNameProperty="filename")
     */
    private $veilleFile;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Organisme::class, inversedBy="veilles")
     */
    private $organisme;

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
        $preuveSlug = $this->organisme->getNomOf() . '-veille-' . $this->intitule;

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
     * @return Veille
     */
    public function setFilename(?string $filename): Veille
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getVeilleFile(): ?File
    {
        return $this->veilleFile;
    }

    /**
     * @param File|null $veilleFile
     * @return Veille
     */
    public function setVeilleFile(?File $veilleFile): Veille
    {
        $this->veilleFile = $veilleFile;
        if($this->veilleFile instanceof UploadedFile) {
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

    public function getOrganisme(): ?Organisme
    {
        return $this->organisme;
    }

    public function setOrganisme(?Organisme $organisme): self
    {
        $this->organisme = $organisme;

        return $this;
    }
}
