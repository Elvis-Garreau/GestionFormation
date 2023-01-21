<?php


namespace App\Controller\admin;


use App\Entity\Formation;
use App\Entity\Objectif;
use App\Form\ObjectifType;
use App\Repository\ObjectifRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminObjectifsController extends AbstractController
{

    /**
     * @var ObjectifRepository
     */
    private $objectifRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(ObjectifRepository $objectifRepository, EntityManagerInterface $entityManager)
    {
        $this->objectifRepository = $objectifRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/objectifs-admin/{id}", name="admin.objectifs.index", methods="GET|POST")
     * @param Formation $formation
     * @return Response
     */
    public function index(Formation $formation): Response
    {
        $objectifs = $this->objectifRepository->findAllByFormation($formation);

        return $this->render('admin/objectifs/objectifs-gerer.html.twig', [
            'objectifs' => $objectifs,
            'formation' => $formation
        ]);
    }

    /**
     * @Route("/objectif-admin/new-{id}", name="admin.objectif.new")
     * @param Formation $formation
     * @param Request $request
     * @return Response
     */
    public function new(Formation $formation, Request $request): Response
    {
        $objectif = new Objectif();

        $form = $this->createForm(ObjectifType::class, $objectif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $objectif->setFormation($formation);
            $this->entityManager->persist($objectif);
            $this->entityManager->flush();
            $this->addFlash('succes', 'l\'objectif a bien été créé');
            $formationId = $formation->getId();
            return $this->redirectToRoute('admin.objectifs.index', ['id' => $formationId]);
        }

        return $this->render('admin/objectifs/objectif-new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/objectif-admin/{id}", name="admin.objectif.edit", methods="GET|POST")
     * @param Objectif $objectif
     * @param Request $request
     * @return Response
     */
    public function edit(Objectif $objectif, Request $request): Response
    {
        $form = $this->createForm(ObjectifType::class, $objectif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('succes', 'L\'objectif a bien été mis à jour');
            $formation = $objectif->getFormation()->getId();
            return $this->redirectToRoute('admin.objectifs.index', ['id' => $formation]);
        }

        return $this->render('admin/objectifs/objectif-edit.html.twig', [
            'objectif' => $objectif,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/objectif-admin/{id}", name="admin.objectif.delete", methods="DELETE")
     * @param Objectif $objectif
     * @param Request $request
     * @return Response
     */
    public function delete(Objectif $objectif, Request $request): Response
    {
        if($this->isCsrfTokenValid('delete' . $objectif->getId(), $request->get('_token'))){
            $this->entityManager->remove($objectif);
            $this->entityManager->flush();
            $this->addFlash('succes', 'l\'objectif a bien été supprimé');
        }
        $formation = $objectif->getFormation()->getId();
        return $this->redirectToRoute('admin.objectifs.index', ['id' => $formation]);
    }

}