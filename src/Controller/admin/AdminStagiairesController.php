<?php


namespace App\Controller\admin;


use App\Entity\Planif;
use App\Entity\Stagiaire;
use App\Form\StagiaireType;
use App\Repository\StagiaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminStagiairesController extends AbstractController
{

    /**
     * @var StagiaireRepository
     */
    private $stagiaireRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(StagiaireRepository $stagiaireRepository, EntityManagerInterface $entityManager)
    {
        $this->stagiaireRepository = $stagiaireRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/stagaires-admin/{id}", name="admin.stagiaires.index", methods="GET|POST")
     * @param Planif $planif
     * @return Response
     */
    public function index(Planif $planif): Response
    {
        $stagiaires = $this->stagiaireRepository->findAllByPlanif($planif);

        return $this->render('admin/stagiaires/stagiaires-gerer.html.twig', [
            'stagiaires' => $stagiaires,
            'planif' => $planif
        ]);
    }

    /**
     * @Route("/stagiaire-admin/new-{id}", name="admin.stagiaire.new")
     * @param Planif $planif
     * @param Request $request
     * @return Response
     */
    public function new(Planif $planif, Request $request): Response
    {
        $stagiaire = new Stagiaire();

        $form = $this->createForm(StagiaireType::class, $stagiaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $stagiaire->setPlanif($planif);
            $this->entityManager->persist($stagiaire);
            $this->entityManager->flush();
            $this->addFlash('succes', 'le stagiaire a bien été créé');
            $planifId = $planif->getId();
            return $this->redirectToRoute('admin.stagiaires.index', ['id' => $planifId]);
        }

        return $this->render('admin/stagiaires/stagiaire-new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/stagiaire-admin/{id}", name="admin.stagiaire.edit", methods="GET|POST")
     * @param Stagiaire $stagiaire
     * @param Request $request
     * @return Response
     */
    public function edit(Stagiaire $stagiaire, Request $request): Response
    {
        $form = $this->createForm(StagiaireType::class, $stagiaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('succes', 'Le stagiaire a bien été mis à jour');
            $planif = $stagiaire->getPlanif()->getId();
            return $this->redirectToRoute('admin.stagiaires.index', ['id' => $planif]);
        }

        return $this->render('admin/stagiaires/stagiaires-edit.html.twig', [
            'stagiaire' => $stagiaire,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/stagiaire-admin/{id}", name="admin.stagiaire.delete", methods="DELETE")
     * @param Stagiaire $stagiaire
     * @param Request $request
     * @return Response
     */
    public function delete(Stagiaire $stagiaire, Request $request): Response
    {
        if($this->isCsrfTokenValid('delete' . $stagiaire->getId(), $request->get('_token'))){
            $this->entityManager->remove($stagiaire);
            $this->entityManager->flush();
            $this->addFlash('succes', 'le stagiaire a bien été supprimé');
        }
        $planif = $stagiaire->getPlanif()->getId();
        return $this->redirectToRoute('admin.stagiaires.index', ['id' => $planif]);
    }

}