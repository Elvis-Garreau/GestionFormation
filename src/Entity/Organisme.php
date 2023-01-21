<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use App\Repository\OrganismeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * @ORM\Entity(repositoryClass=OrganismeRepository::class)
 * @Vich\Uploadable()
 */
class Organisme
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="organisme_image", fileNameProperty="filename")
     */
    private $imageFile;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $livretFilename;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="organisme_livret", fileNameProperty="livretFilename")
     */
    private $livretFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_of;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse_voie;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[0-9]{5}$/")
     */
    private $adresse_CP;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse_ville;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[0-9]{11}$/")
     */
    private $declaration_activite;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[0-9]{14}$/")
     */
    private $siret;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="organisme")
     */
    private $users;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=Formation::class, mappedBy="organisme")
     */
    private $formations;

    /**
     * @ORM\OneToMany(targetEntity=Formateur::class, mappedBy="organisme")
     */
    private $formateurs;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[0-9]{10}$/")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[a-z0-9\.\-\_]*@{1}[a-z0-9\_\-\.]*.[a-z]{2,3}?$/")
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[0-9]*$/")
     */
    private $capital;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code_ape;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tva_fr;

    /**
     * @ORM\OneToMany(targetEntity=Client::class, mappedBy="organisme")
     */
    private $clients;

    /**
     * @ORM\OneToMany(targetEntity=Planif::class, mappedBy="organisme")
     */
    private $planifs;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $RCS;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $forme_juridique;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cf_nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cf_prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cf_mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cf_phone;

    /**
     * @ORM\OneToMany(targetEntity=RepresentantOf::class, mappedBy="organisme", cascade={"persist"})
     */
    private $representant;

    /**
     * @ORM\Column(type="boolean")
     */
    private $acces_handicape;

    /**
     * @ORM\OneToMany(targetEntity=Veille::class, mappedBy="organisme")
     */
    private $veilles;

    /**
     * @ORM\Column(type="boolean")
     */
    private $LivretAccueil;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->formations = new ArrayCollection();
        $this->formateurs = new ArrayCollection();
        $this->clients = new ArrayCollection();
        $this->planifs = new ArrayCollection();
        $this->representant = new ArrayCollection();
        $this->veilles = new ArrayCollection();
    }

    /**
     * @return Collection|Organisme[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUsers(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setOrganisme($this);
        }

        return $this;
    }

    public function removeUsers(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            if ($user->getOrganisme() === $this) {
                $user->setOrganisme(Null);
            }
        }
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomOf(): ?string
    {
        return $this->nom_of;
    }

    public function setNomOf(string $nom_of): self
    {
        $this->nom_of = $nom_of;

        return $this;
    }

    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->nom_of);
    }

    public function getSlugLivret(): string
    {
       $slugLivret = $this->getSlug() . '_livret_acceuil';
       return (new Slugify())->slugify($slugLivret);
    }

    public function getAdresseVoie(): ?string
    {
        return $this->adresse_voie;
    }

    public function setAdresseVoie(string $adresse_voie): self
    {
        $this->adresse_voie = $adresse_voie;

        return $this;
    }

    public function getAdresseCP(): ?string
    {
        return $this->adresse_CP;
    }

    public function setAdresseCP(string $adresse_CP): self
    {
        $this->adresse_CP = $adresse_CP;

        return $this;
    }

    public function getAdresseVille(): ?string
    {
        return $this->adresse_ville;
    }

    public function setAdresseVille(string $adresse_ville): self
    {
        $this->adresse_ville = $adresse_ville;

        return $this;
    }

    public function getDeclarationActivite(): ?string
    {
        return $this->declaration_activite;
    }

    public function setDeclarationActivite(string $declaration_activite): self
    {
        $this->declaration_activite = $declaration_activite;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function getSiretFormated(): string
    {
        $siret = $this->siret;

        preg_match( '/([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{5})$/', $siret,  $matches );
        $siretFormated = $matches[1] . ' ' .$matches[2] . ' ' . $matches[3] . ' ' . $matches[4];

        return $siretFormated;
    }

    public function setSiret(string $siret): self
    {
        $this->siret = $siret;

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
     * @return Organisme
     */
    public function setFilename(?string $filename): Organisme
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $imageFile
     * @return Organisme
     */
    public function setImageFile(?File $imageFile): Organisme
    {
        $this->imageFile = $imageFile;
        if($this->imageFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLivretFilename(): ?string
    {
        return $this->livretFilename;
    }

    /**
     * @param string|null $livretFilename
     * @return Organisme
     */
    public function setLivretFilename(?string $livretFilename): Organisme
    {
        $this->livretFilename = $livretFilename;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getLivretFile(): ?File
    {
        return $this->livretFile;
    }

    /**
     * @param File|null $livretFile
     * @return Organisme
     */
    public function setLivretFile(?File $livretFile): Organisme
    {
        $this->livretFile = $livretFile;
        if($this->livretFile instanceof UploadedFile) {
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

    /**
     * @return Collection|Formation[]
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations[] = $formation;
            $formation->setOrganismeId($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        if ($this->formations->removeElement($formation)) {
            // set the owning side to null (unless already changed)
            if ($formation->getOrganismeId() === $this) {
                $formation->setOrganismeId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Formateur[]
     */
    public function getFormateurs(): Collection
    {
        return $this->formateurs;
    }

    public function addFormateur(Formateur $formateur): self
    {
        if (!$this->formateurs->contains($formateur)) {
            $this->formateurs[] = $formateur;
            $formateur->setOrganisme($this);
        }

        return $this;
    }

    public function removeFormateur(Formateur $formateur): self
    {
        if ($this->formateurs->removeElement($formateur)) {
            // set the owning side to null (unless already changed)
            if ($formateur->getOrganisme() === $this) {
                $formateur->setOrganisme(null);
            }
        }

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function getTelephoneFormated(): string
    {
        $telephone = $this->telephone;

        preg_match( '/([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})$/', $telephone,  $matches );
        $telephone = $matches[1] . ' ' .$matches[2] . ' ' . $matches[3] . ' ' . $matches[4] . ' ' . $matches[5];

        return $telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getCapital(): ?string
    {
        return $this->capital;
    }

    public function setCapital(string $capital): self
    {
        $this->capital = $capital;

        return $this;
    }

    public function getCodeApe(): ?string
    {
        return $this->code_ape;
    }

    public function setCodeApe(string $code_ape): self
    {
        $this->code_ape = $code_ape;

        return $this;
    }

    public function getTvaFr(): ?string
    {
        return $this->tva_fr;
    }

    public function setTvaFr(string $tva_fr): self
    {
        $this->tva_fr = $tva_fr;

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setOrganisme($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getOrganisme() === $this) {
                $client->setOrganisme(null);
            }
        }

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
            $planif->setOrganisme($this);
        }

        return $this;
    }

    public function removePlanif(Planif $planif): self
    {
        if ($this->planifs->removeElement($planif)) {
            // set the owning side to null (unless already changed)
            if ($planif->getOrganisme() === $this) {
                $planif->setOrganisme(null);
            }
        }

        return $this;
    }

    public function getRCS(): ?string
    {
        return $this->RCS;
    }

    public function setRCS(string $RCS): self
    {
        $this->RCS = $RCS;

        return $this;
    }

    public function getFormeJuridique(): ?string
    {
        return $this->forme_juridique;
    }

    public function setFormeJuridique(string $forme_juridique): self
    {
        $this->forme_juridique = $forme_juridique;

        return $this;
    }

    public function getCfNom(): ?string
    {
        return $this->cf_nom;
    }

    public function setCfNom(string $cf_nom): self
    {
        $this->cf_nom = $cf_nom;

        return $this;
    }

    public function getCfPrenom(): ?string
    {
        return $this->cf_prenom;
    }

    public function setCfPrenom(string $cf_prenom): self
    {
        $this->cf_prenom = $cf_prenom;

        return $this;
    }

    public function getCfMail(): ?string
    {
        return $this->cf_mail;
    }

    public function setCfMail(string $cf_mail): self
    {
        $this->cf_mail = $cf_mail;

        return $this;
    }

    public function getCfPhone(): ?string
    {
        return $this->cf_phone;
    }

    public function getCfPhoneFormated(): string
    {
        $telephone = $this->cf_phone;

        preg_match( '/([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})$/', $telephone,  $matches );
        $telephone = $matches[1] . ' ' .$matches[2] . ' ' . $matches[3] . ' ' . $matches[4] . ' ' . $matches[5];

        return $telephone;
    }

    public function setCfPhone(string $cf_phone): self
    {
        $this->cf_phone = $cf_phone;

        return $this;
    }

    /**
     * @return Collection|RepresentantOf[]
     */
    public function getRepresentant(): Collection
    {
        return $this->representant;
    }

    public function addRepresentant(RepresentantOf $representant): self
    {
        if (!$this->representant->contains($representant)) {
            $this->representant[] = $representant;
            $representant->setOrganisme($this);
        }

        $this->representant->add($representant);

        return $this;
    }

    public function removeRepresentant(RepresentantOf $representant): self
    {
        if ($this->representant->removeElement($representant)) {
            // set the owning side to null (unless already changed)
            if ($representant->getOrganisme() === $this) {
                $representant->setOrganisme(null);
            }
        }

        return $this;
    }

    public function getAccesHandicape(): ?bool
    {
        return $this->acces_handicape;
    }

    public function setAccesHandicape(bool $acces_handicape): self
    {
        $this->acces_handicape = $acces_handicape;

        return $this;
    }

    /**
     * @return Collection|Veille[]
     */
    public function getVeilles(): Collection
    {
        return $this->veilles;
    }

    public function addVeille(Veille $veille): self
    {
        if (!$this->veilles->contains($veille)) {
            $this->veilles[] = $veille;
            $veille->setOrganisme($this);
        }

        return $this;
    }

    public function removeVeille(Veille $veille): self
    {
        if ($this->veilles->removeElement($veille)) {
            // set the owning side to null (unless already changed)
            if ($veille->getOrganisme() === $this) {
                $veille->setOrganisme(null);
            }
        }

        return $this;
    }

    public function getLivretAccueil(): ?bool
    {
        return $this->LivretAccueil;
    }

    public function setLivretAccueil(bool $LivretAccueil): self
    {
        $this->LivretAccueil = $LivretAccueil;

        return $this;
    }

}
