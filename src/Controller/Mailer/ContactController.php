<?php


namespace App\Controller\Mailer;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, MailerController $mail)
    {

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mail->sendContact($contact);
            $this->addFlash('succes', 'Le mail a bien été envoyé');
            return $this->redirectToRoute('contact');
        }

        return $this->render('pages/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }

}