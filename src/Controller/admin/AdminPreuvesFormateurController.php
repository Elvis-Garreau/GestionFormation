<?php


namespace App\Controller\admin;


use App\Entity\Formateur;
use App\Entity\PreuveFormateur;
use App\Form\PreuveFormateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPreuvesFormateurController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/preuve-formateur-admin/new-{id}", name="admin.preuve.formateur.new")
     * @param Formateur $formateur
     * @param Request $request
     * @return Response
     */
    public function new(Formateur $formateur, Request $request): Response
    {
        $preuve = new PreuveFormateur();

        $form = $this->createForm(PreuveFormateurType::class, $preuve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $preuve->setFormateur($formateur);
            $this->entityManager->persist($preuve);
            $this->entityManager->flush();
            $this->addFlash('succes', 'L\'élément de preuve a bien été ajoutée');
            $formateurId = $formateur->getId();
            $formateurSlug = $formateur->getSlug();
            return $this->redirectToRoute('formateur.show', ['id' => $formateurId, 'slug' => $formateurSlug]);
        }

        return $this->render('admin/preuves-formateur/preuve-formateur-new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("//preuve-formateur-admin/edit-{id}", name="admin.preuve.formateur.edit", methods="GET|POST")
     * @param PreuveFormateur $preuveFormateur
     * @param Request $request
     * @return Response
     */
    public function edit(PreuveFormateur $preuveFormateur, Request $request): Response
    {
        $form = $this->createForm(PreuveFormateurType::class, $preuveFormateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('succes', 'L\'élément de preuve a bien été mise à jour');
            $formateur = $preuveFormateur->getFormateur();
            $formateurId = $formateur->getId();
            $formateurSlug = $formateur->getSlug();
            return $this->redirectToRoute('formateur.show', ['id' => $formateurId, 'slug' => $formateurSlug]);
        }

        return $this->render('admin/preuves-formateur/preuve-formateur-edit.html.twig', [
            'preuveFormateur' => $preuveFormateur,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/preuve-formateur-admin/{id}", name="admin.preuve.formateur.delete", methods="DELETE")
     * @param PreuveFormateur $preuveFormateur
     * @param Request $request
     * @return Response
     */
    public function delete(PreuveFormateur $preuveFormateur, Request $request): Response
    {
        if($this->isCsrfTokenValid('delete' . $preuveFormateur->getId(), $request->get('_token'))){
            $this->entityManager->remove($preuveFormateur);
            $this->entityManager->flush();
            $this->addFlash('succes', 'L\'élément de preuve  bien été supprimée');
        }
        $formateur = $preuveFormateur->getFormateur();
        $formateurId = $formateur->getId();
        $formateurSlug = $formateur->getSlug();
        return $this->redirectToRoute('formateur.show', ['id' => $formateurId, 'slug' => $formateurSlug]);
    }

}