<?php


namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class MailAmont
{

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     */
    private $prenom;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     */
    private $nom;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $mailClient;

    /**
     * @var bool|null
     */
    private $nouveauClient;

    /**
     * @var Formation
     */
    private $programme;

    /**
     * @return string
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     * @return MailAmont
     */
    public function setPrenom(string $prenom): MailAmont
    {
        $this->prenom = $prenom;
        return $this;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     * @return MailAmont
     */
    public function setNom(string $nom): MailAmont
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return string
     */
    public function getMailClient(): string
    {
        return $this->mailClient;
    }

    /**
     * @param string $mailClient
     * @return MailAmont
     */
    public function setMailClient(string $mailClient): MailAmont
    {
        $this->mailClient = $mailClient;
        return $this;
    }


    /**
     * @return bool|null
     */
    public function getNouveauClient(): ?bool
    {
        return $this->nouveauClient;
    }

    /**
     * @param bool|null $nouveauClient
     * @return MailAmont
     */
    public function setNouveauClient(?bool $nouveauClient): MailAmont
    {
        $this->nouveauClient = $nouveauClient;
        return $this;
    }

    /**
     * @return Formation
     */
    public function getProgramme(): Formation
    {
        return $this->programme;
    }

    /**
     * @param Formation $programme
     * @return MailAmont
     */
    public function setProgramme(Formation $programme): MailAmont
    {
        $this->programme = $programme;
        return $this;
    }


}