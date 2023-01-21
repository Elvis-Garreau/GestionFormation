<?php


namespace App\Controller\Mailer;


use App\Entity\Contact;
use App\Entity\Formation;
use App\Entity\MailAmont;
use App\Entity\Planif;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{

    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param Formation $formation
     * @return string
     */
    public function getPath(Formation $formation): string
    {
        $id = $formation->getId();
        $of = $formation->getOrganisme()->getSlug();
        $nom = $formation->getSlug();

        return 'convert/' . $of . '/' . $nom . $id;
    }

    /**
     * @param MailAmont $contact
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function sendProgrammeAmont(MailAmont $contact)
    {

        $user = $this->getUser();
        $userNom = $user->getNom() . ' ' . $user->getPrenom();
        $userMail = $user->getEmail();

        $organisme = $user->getOrganisme()->getNomOf();

        $clientNom = $contact->getNom() . ' ' . $contact->getPrenom();
        $clientMail = $contact->getMailClient();

        $formation = $contact->getProgramme();
        $filenameProgramme = $formation->getSlug() . $formation->getId() . '-programme';
        $filenameInscrStagiaire = $formation->getSlug() . $formation->getId() . '-inscription-stagiaire';
        $filenameInscrClient = $formation->getSlug() . $formation->getId() . '-inscription-client';

        $logoOF = 'logo-' . $formation->getOrganisme()->getSlug() . '.png';

        $email = (new TemplatedEmail())
            ->from(new Address('formation@abil49.fr', $userNom))
            ->to(new Address($clientMail, $clientNom))
            ->replyTo($userMail)
            ->subject('Programme de la formation : ' . $contact->getProgramme()->getNomFormation())
            ->htmlTemplate('emails/programme-amont.html.twig')
            ->embedFromPath('images/organismes/' . $logoOF,'logo')
            ->context([
                'contact' => $contact,
                'user' => $userNom,
                'organisme' => $organisme,
                'filenameProgramme' => $filenameProgramme,
                'filenameInscrStagiaire' => $filenameInscrStagiaire,
                'filenameInscrClient' => $filenameInscrClient
            ])
        ;

        $this->mailer->send($email);

    }

    /**
     * @Route("/envoie-mail-convention/{id}", name="send.convention")
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function sendConvention(Planif $planif)
    {

        $user = $this->getUser();
        $userNom = $user->getNom() . ' ' . $user->getPrenom();
        $userMail = $user->getEmail();
        $organisme = $user->getOrganisme()->getNomOf();

        $destMail = $planif->getClient()->getRepresentantMail();
        $destNom = $planif->getClient()->getRepresentantPrenom() . ' ' . $planif->getClient()->getRepresentantNom();

        $contactPrenom = $planif->getClient()->getRepresentantPrenom();

        $subject = $organisme . ' - Convention de formation - ' . $planif->getProgramme()->getSlug();

        $logoOF = 'logo-' . $planif->getOrganisme()->getSlug() . '.png';

        $formation = $planif->getProgramme();
        $filenameConvention = $planif->getDateDebut() . $formation->getId() . '-convention';
        $filenameProgramme = $planif->getDateDebut() . $formation->getId() . '-programme';

        $email = (new TemplatedEmail())
            ->from(new Address('formation@abil49.fr', $userNom))
            ->to(new Address($destMail, $destNom))
            ->replyTo($userMail)
            ->subject($subject)
            ->htmlTemplate('emails/convention.html.twig')
            ->embedFromPath('images/organismes/' . $logoOF,'logo')
            ->context([
                'planif' => $planif,
                'contactPrenom' => $contactPrenom,
                'filenameConvention' => $filenameConvention,
                'filenameProgramme' => $filenameProgramme,
                'organisme' => $organisme
            ])
        ;

        $this->mailer->send($email);

        $planifId = $planif->getId();
        return $this->redirectToRoute('planif.finder', ['id' => $planifId]);

    }

    /**
     * @Route("/envoie-mail-docs-formateur/{id}", name="send.docs.formateur")
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function sendDocFormateur(Planif $planif)
    {

        $user = $this->getUser();
        $userNom = $user->getNom() . ' ' . $user->getPrenom();
        $userMail = $user->getEmail();
        $organisme = $user->getOrganisme()->getNomOf();

        $destMail = $planif->getFormateur()->getFormateurMail();
        $destNom = $planif->getFormateur()->getFormateurPrenom() . ' ' . $planif->getFormateur()->getFormateurNom();

        $formateur = $planif->getFormateur()->getFormateurPrenom();

        $subject = 'Document de formation - ' . $planif->getProgramme()->getSlug();

        $logoOF = 'logo-' . $planif->getOrganisme()->getSlug() . '.png';

        $email = (new TemplatedEmail())
            ->from(new Address('formation@abil49.fr', $userNom))
            ->to(new Address($destMail, $destNom))
            ->replyTo($userMail)
            ->subject($subject)
            ->htmlTemplate('emails/doc-formateur.html.twig')
            ->embedFromPath('images/organismes/' . $logoOF,'logo')
            ->context([
                'planif' => $planif,
                'user' => $userNom,
                'formateur' => $formateur,
                'organisme' => $organisme
            ])
        ;

        $this->mailer->send($email);

        $planifId = $planif->getId();
        return $this->redirectToRoute('planif.finder', ['id' => $planifId]);

    }

    /**
     * @param Contact $contact
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function sendContact(Contact $contact)
    {

        $user = $this->getUser();
        $userNom = $user->getNom() . ' ' . $user->getPrenom();
        $userMail = $user->getEmail();
        $organisme = $user->getOrganisme()->getNomOf();

        if ($contact->getChoixcontact() == 1) {
            $destMail = 'claire@abil49.fr';
            $destNom = 'Claire Sala';
        } elseif ($contact->getChoixcontact() == 2) {
            $destMail = 'elvis@unicornwal.com';
            $destNom = 'Elvis Garreau';
        }

        $subject = 'FORM\'Abil - ' . $contact->getObjet();

        $email = (new TemplatedEmail())
            ->from(new Address('formation@abil49.fr', $userNom))
            ->to(new Address($destMail, $destNom))
            ->replyTo($userMail)
            ->subject($subject)
            ->htmlTemplate('emails/contact.html.twig')
            ->context([
                'contact' => $contact,
                'user' => $userNom,
                'organisme' => $organisme
            ])
        ;

        $this->mailer->send($email);

    }

}