<?php

namespace App\Controller\admin;

use App\Entity\Formation;
use App\Entity\ModuleFormation;
use App\Entity\Objectif;
use App\Entity\Prerequi;
use App\Form\FormationEditNomType;
use App\Form\FormationEditPublicType;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminFormationsController extends AbstractController
{

    /**
     * @var FormationRepository
     */
    private $formationRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(FormationRepository $formationRepository, EntityManagerInterface $entityManager)
    {
        $this->formationRepository = $formationRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/formation-admin/new", name="admin.formation.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $userOrganisme = $this->getUser()->getOrganisme()->getId();

        $formations = $this->formationRepository->findByOrganisme($userOrganisme);

        $formation = new Formation();

        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $organisme = $this->getUser()->getOrganisme();
            $formation->setOrganisme($organisme);
            $this->entityManager->persist($formation);
            $this->entityManager->flush();
            $this->addFlash('succes', 'la formation a bien été créé');
            return $this->redirectToRoute('formations.index');
        }

        return $this->render('admin/formations/formations-new.html.twig', [
            'formations' => $formations,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/formation-admin/edit-nom{id}", name="admin.formation.editNom", methods="GET|POST")
     * @param Formation $formation
     * @param Request $request
     * @return Response
     */
    public function editNom(Formation $formation, Request $request): Response
    {
        $form = $this->createForm(FormationEditNomType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('succes', 'La formation a bien été mis à jour');
            return $this->redirectToRoute('formation.show', ['id' => $formation->getId(), 'slug'=>$formation->getSlug()]);
        }

        return $this->render('admin/formations/formation-edit-nom.html.twig', [
            'formation' => $formation,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/formation-admin/edit-public-{id}", name="admin.formation.editPublic", methods="GET|POST")
     * @param Formation $formation
     * @param Request $request
     * @return Response
     */
    public function editPublic(Formation $formation, Request $request): Response
    {
        $form = $this->createForm(FormationEditPublicType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('succes', 'La formation a bien été mis à jour');
            return $this->redirectToRoute('formation.show', ['id' => $formation->getId(), 'slug'=>$formation->getSlug()]);
        }

        return $this->render('admin/formations/formation-edit-public.html.twig', [
            'formation' => $formation,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/formation-admin/{id}", name="admin.formation.delete", methods="DELETE")
     * @param Formation $formation
     * @param Request $request
     * @return Response
     */
    public function delete(Formation $formation, Request $request): Response
    {
        if($this->isCsrfTokenValid('delete' . $formation->getId(), $request->get('_token'))){
            $this->entityManager->remove($formation);
            $this->entityManager->flush();
            $this->addFlash('succes', 'la formation a bien été supprimé');
        }
        return $this->redirectToRoute('formations.index');
    }
}