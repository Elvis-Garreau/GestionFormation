<?php

namespace App\Controller\admin;

use App\Entity\Organisme;
use App\Form\OrganismesEditType;
use App\Form\OrganismesType;
use App\Repository\OrganismeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminOrganismesController extends AbstractController
{

    /**
    /**
     * @var OrganismeRepository
     */
    private $organismeRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(OrganismeRepository $organismeRepository, EntityManagerInterface $entityManager)
    {
        $this->organismeRepository = $organismeRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/organisme-admin", name="admin.organismes.index")
     * @return Response
     */
    public function index(): Response
    {
        $organismes = $this->organismeRepository->findAll();

        return $this->render('admin/organismes/organismes-gerer.html.twig', [
            'organismes' => $organismes
        ]);
    }

    /**
     * @Route("/organisme-admin/new", name="admin.organisme.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $organisme = new Organisme();

        $form = $this->createForm(OrganismesType::class, $organisme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($organisme);
            $this->entityManager->flush();
            $this->addFlash('succes', 'l\'organisme a bien été créé');
            return $this->redirectToRoute('admin.organismes.index');
        }

        return $this->render('admin/organismes/organismes-new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/organisme-admin/{id}", name="admin.organisme.edit", methods="GET|POST")
     * @param Organisme $organisme
     * @param Request $request
     * @return Response
     */
    public function edit(Organisme $organisme, Request $request): Response
    {
        $userOfId = $this->getUser()->getOrganisme()->getId();
        $userRole = $this->getUser()->getRoleAdmin();
        $organismeId = $organisme->getId();

        if ($userOfId != $organismeId && $userRole == false){
            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(OrganismesEditType::class, $organisme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('succes', 'L\'organisme a bien été mis à jour');
            return $this->redirectToRoute('admin.organismes.index');
        }

        return $this->render('admin/organismes/organisme-edit.html.twig', [
            'organisme' => $organisme,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/organisme-admin/{id}", name="admin.organisme.delete", methods="DELETE")
     * @param Organisme $organisme
     * @param Request $request
     * @return Response
     */
    public function delete(Organisme $organisme, Request $request): Response
    {
        if($this->isCsrfTokenValid('delete' . $organisme->getId(), $request->get('_token'))){
            $this->entityManager->remove($organisme);
            $this->entityManager->flush();
            $this->addFlash('succes', 'l\'organisme a bien été supprimé');
        }
        return $this->redirectToRoute('admin.organismes.index');
    }

}