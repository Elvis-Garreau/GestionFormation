<?php


namespace App\Entity;


use Symfony\Component\Validator\Constraints as Assert;

class Contact
{

    /**
     * @var string|null
     * @Assert\NotBlank
     */
    private $choixcontact;

    /**
     * @var string|null
     * @Assert\NotBlank
     */
    private $objet;

    /**
     * @var string|null
     * @Assert\NotBlank
     * @Assert\Length(min=10)
     */
    private $message;

    /**
     * @return string|null
     */
    public function getChoixcontact(): ?string
    {
        return $this->choixcontact;
    }

    /**
     * @param string|null $choixcontact
     * @return Contact
     */
    public function setChoixcontact(?string $choixcontact): Contact
    {
        $this->choixcontact = $choixcontact;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getObjet(): ?string
    {
        return $this->objet;
    }

    /**
     * @param string|null $objet
     * @return Contact
     */
    public function setObjet(?string $objet): Contact
    {
        $this->objet = $objet;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     * @return Contact
     */
    public function setMessage(?string $message): Contact
    {
        $this->message = $message;
        return $this;
    }

}