<?php

namespace App\Entity;

use App\Repository\BiblDocuRepository;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=BiblDocuRepository::class)
 * @Vich\Uploadable()
 */
class BiblDocu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $filename01;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="bibli_01", fileNameProperty="filename01")
     */
    private $imageFile01;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $filename02;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="bibli_02", fileNameProperty="filename02")
     */
    private $imageFile02;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $filename03;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="bibli_03", fileNameProperty="filename03")
     */
    private $imageFile03;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $filename04;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="bibli_04", fileNameProperty="filename04")
     */
    private $imageFile04;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $filename05;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="bibli_05", fileNameProperty="filename05")
     */
    private $imageFile05;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $filename06;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="bibli_06", fileNameProperty="filename06")
     */
    private $imageFile06;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $filename07;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="bibli_07", fileNameProperty="filename07")
     */
    private $imageFile07;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $filename08;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="bibli_08", fileNameProperty="filename08")
     */
    private $imageFile08;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $filename09;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="bibli_09", fileNameProperty="filename09")
     */
    private $imageFile09;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $filename10;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="bibli_10", fileNameProperty="filename10")
     */
    private $imageFile10;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $filename11;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="bibli_11", fileNameProperty="filename11")
     */
    private $imageFile11;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $filename12;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="bibli_12", fileNameProperty="filename12")
     */
    private $imageFile12;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @return string|null
     */
    public function getFilename01(): ?string
    {
        return $this->filename01;
    }

    /**
     * @param string|null $filename01
     * @return BiblDocu
     */
    public function setFilename01(?string $filename01): BiblDocu
    {
        $this->filename01 = $filename01;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile01(): ?File
    {
        return $this->imageFile01;
    }

    /**
     * @param File|null $imageFile01
     * @return BiblDocu
     */
    public function setImageFile01(?File $imageFile01): BiblDocu
    {
        $this->imageFile01 = $imageFile01;
        if($this->imageFile01 instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilename02(): ?string
    {
        return $this->filename02;
    }

    /**
     * @param string|null $filename02
     * @return BiblDocu
     */
    public function setFilename02(?string $filename02): BiblDocu
    {
        $this->filename02 = $filename02;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile02(): ?File
    {
        return $this->imageFile02;
    }

    /**
     * @param File|null $imageFile02
     * @return BiblDocu
     */
    public function setImageFile02(?File $imageFile02): BiblDocu
    {
        $this->imageFile02 = $imageFile02;
        if($this->imageFile02 instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilename03(): ?string
    {
        return $this->filename03;
    }

    /**
     * @param string|null $filename03
     * @return BiblDocu
     */
    public function setFilename03(?string $filename03): BiblDocu
    {
        $this->filename03 = $filename03;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile03(): ?File
    {
        return $this->imageFile03;
    }

    /**
     * @param File|null $imageFile03
     * @return BiblDocu
     */
    public function setImageFile03(?File $imageFile03): BiblDocu
    {
        $this->imageFile03 = $imageFile03;
        if($this->imageFile03 instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilename04(): ?string
    {
        return $this->filename04;
    }

    /**
     * @param string|null $filename04
     * @return BiblDocu
     */
    public function setFilename04(?string $filename04): BiblDocu
    {
        $this->filename04 = $filename04;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile04(): ?File
    {
        return $this->imageFile04;
    }

    /**
     * @param File|null $imageFile04
     * @return BiblDocu
     */
    public function setImageFile04(?File $imageFile04): BiblDocu
    {
        $this->imageFile04 = $imageFile04;
        if($this->imageFile04 instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilename05(): ?string
    {
        return $this->filename05;
    }

    /**
     * @param string|null $filename05
     * @return BiblDocu
     */
    public function setFilename05(?string $filename05): BiblDocu
    {
        $this->filename05 = $filename05;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile05(): ?File
    {
        return $this->imageFile05;
    }

    /**
     * @param File|null $imageFile05
     * @return BiblDocu
     */
    public function setImageFile05(?File $imageFile05): BiblDocu
    {
        $this->imageFile05 = $imageFile05;
        if($this->imageFile05 instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilename06(): ?string
    {
        return $this->filename06;
    }

    /**
     * @param string|null $filename06
     * @return BiblDocu
     */
    public function setFilename06(?string $filename06): BiblDocu
    {
        $this->filename06 = $filename06;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile06(): ?File
    {
        return $this->imageFile06;
    }

    /**
     * @param File|null $imageFile06
     * @return BiblDocu
     */
    public function setImageFile06(?File $imageFile06): BiblDocu
    {
        $this->imageFile06 = $imageFile06;
        if($this->imageFile06 instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilename07(): ?string
    {
        return $this->filename07;
    }

    /**
     * @param string|null $filename07
     * @return BiblDocu
     */
    public function setFilename07(?string $filename07): BiblDocu
    {
        $this->filename07 = $filename07;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile07(): ?File
    {
        return $this->imageFile07;
    }

    /**
     * @param File|null $imageFile07
     * @return BiblDocu
     */
    public function setImageFile07(?File $imageFile07): BiblDocu
    {
        $this->imageFile07 = $imageFile07;
        if($this->imageFile07 instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilename08(): ?string
    {
        return $this->filename08;
    }

    /**
     * @param string|null $filename08
     * @return BiblDocu
     */
    public function setFilename08(?string $filename08): BiblDocu
    {
        $this->filename08 = $filename08;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile08(): ?File
    {
        return $this->imageFile08;
    }

    /**
     * @param File|null $imageFile08
     * @return BiblDocu
     */
    public function setImageFile08(?File $imageFile08): BiblDocu
    {
        $this->imageFile08 = $imageFile08;
        if($this->imageFile08 instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilename09(): ?string
    {
        return $this->filename09;
    }

    /**
     * @param string|null $filename09
     * @return BiblDocu
     */
    public function setFilename09(?string $filename09): BiblDocu
    {
        $this->filename09 = $filename09;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile09(): ?File
    {
        return $this->imageFile09;
    }

    /**
     * @param File|null $imageFile09
     * @return BiblDocu
     */
    public function setImageFile09(?File $imageFile09): BiblDocu
    {
        $this->imageFile09 = $imageFile09;
        if($this->imageFile09 instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilename10(): ?string
    {
        return $this->filename10;
    }

    /**
     * @param string|null $filename10
     * @return BiblDocu
     */
    public function setFilename10(?string $filename10): BiblDocu
    {
        $this->filename10 = $filename10;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile10(): ?File
    {
        return $this->imageFile10;
    }

    /**
     * @param File|null $imageFile10
     * @return BiblDocu
     */
    public function setImageFile10(?File $imageFile10): BiblDocu
    {
        $this->imageFile10 = $imageFile10;
        if($this->imageFile10 instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilename11(): ?string
    {
        return $this->filename11;
    }

    /**
     * @param string|null $filename11
     * @return BiblDocu
     */
    public function setFilename11(?string $filename11): BiblDocu
    {
        $this->filename11 = $filename11;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile11(): ?File
    {
        return $this->imageFile11;
    }

    /**
     * @param File|null $imageFile11
     * @return BiblDocu
     */
    public function setImageFile11(?File $imageFile11): BiblDocu
    {
        $this->imageFile11 = $imageFile11;
        if($this->imageFile11 instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilename12(): ?string
    {
        return $this->filename12;
    }

    /**
     * @param string|null $filename12
     * @return BiblDocu
     */
    public function setFilename12(?string $filename12): BiblDocu
    {
        $this->filename12 = $filename12;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile12(): ?File
    {
        return $this->imageFile12;
    }

    /**
     * @param File|null $imageFile12
     * @return BiblDocu
     */
    public function setImageFile12(?File $imageFile12): BiblDocu
    {
        $this->imageFile12 = $imageFile12;
        if($this->imageFile12 instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getSlug01(): string
    {
        $slug01 = 'filename-01';
        return (new Slugify())->slugify($slug01);
    }

    public function getSlug02(): string
    {
        $slug02 = 'filename-02';
        return (new Slugify())->slugify($slug02);
    }

    public function getSlug03(): string
    {
        $slug03 = 'filename-03';
        return (new Slugify())->slugify($slug03);
    }

    public function getSlug04(): string
    {
        $slug04 = 'filename-04';
        return (new Slugify())->slugify($slug04);
    }

    public function getSlug05(): string
    {
        $slug05 = 'filename-05';
        return (new Slugify())->slugify($slug05);
    }

    public function getSlug06(): string
    {
        $slug06 = 'filename-06';
        return (new Slugify())->slugify($slug06);
    }

    public function getSlug07(): string
    {
        $slug07 = 'filename-07';
        return (new Slugify())->slugify($slug07);
    }

    public function getSlug08(): string
    {
        $slug08 = 'filename-08';
        return (new Slugify())->slugify($slug08);
    }

    public function getSlug09(): string
    {
        $slug09 = 'filename-09';
        return (new Slugify())->slugify($slug09);
    }

    public function getSlug10(): string
    {
        $slug10 = 'filename-10';
        return (new Slugify())->slugify($slug10);
    }

    public function getSlug11(): string
    {
        $slug11 = 'filename-11';
        return (new Slugify())->slugify($slug11);
    }

    public function getSlug12(): string
    {
        $slug12 = 'filename-12';
        return (new Slugify())->slugify($slug12);
    }
}
