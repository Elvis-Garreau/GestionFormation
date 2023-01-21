<?php


namespace App\Controller\admin;


use App\Entity\Dates;
use App\Entity\ModuleFormation;
use App\Entity\Objectif;
use App\Entity\Planif;
use App\Entity\PlanifSearch;
use App\Entity\Prerequi;
use App\Form\PlanifEditType;
use App\Form\PlanifSearchType;
use App\Form\PlanifType;
use App\Repository\PlanifRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPlanifController extends AbstractController
{

    /**
     * @var PlanifRepository
     */
    private $planifRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(PlanifRepository $planifRepository, EntityManagerInterface $entityManager)
    {
        $this->planifRepository = $planifRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/planification-admin", name="admin.planifs.index")
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $form = $this->createForm(PlanifSearchType::class);
        $search = $form->handleRequest($request);

        $userOrganisme = $this->getUser()->getOrganisme()->getId();

        $planifs = $paginator->paginate(
            $this->planifRepository->findByOrganismeWithSearch($userOrganisme, $search),
            $request->query->getInt('page', 1),
            8
        );

        return $this->render('admin/planifs/planifications-gerer.html.twig', [
            'planifs' => $planifs,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/planification-admin/new", name="admin.planif.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $planif = new Planif();

        $form = $this->createForm(PlanifType::class, $planif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $organisme = $this->getUser()->getOrganisme();
            $planif->setOrganisme($organisme);
            $date_debut = $planif->getDates()->first()->getDateAnnee() . $planif->getDates()->first()->getDateMois() . $planif->getDates()->first()->getDateJour();
            $planif->setDateDebut($date_debut);
            $date_fin = $planif->getDates()->last()->getDateAnnee() . $planif->getDates()->last()->getDateMois() . $planif->getDates()->last()->getDateJour();
            $planif->setDateFin($date_fin);
            $this->entityManager->persist($planif);
            $this->entityManager->flush();
            $this->addFlash('succes', 'la formation a bien été planifiée');
            return $this->redirectToRoute('admin.planifs.index');
        }

        return $this->render('admin/planifs/planifs-new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/planification-admin/{id}", name="admin.planif.edit", methods="GET|POST")
     * @param Planif $planif
     * @param Request $request
     * @return Response
     */
    public function edit(Planif $planif, Request $request): Response
    {
        $form = $this->createForm(PlanifEditType::class, $planif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('succes', 'La planification a bien été mis à jour');
            return $this->redirectToRoute('admin.planifs.index');
        }

        return $this->render('admin/planifs/planif-edit.html.twig', [
            'planif' => $planif,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/planification-admin/{id}", name="admin.planif.delete", methods="DELETE")
     * @param Planif $planif
     * @param Request $request
     * @return Response
     */
    public function delete(Planif $planif, Request $request): Response
    {
        if($this->isCsrfTokenValid('delete' . $planif->getId(), $request->get('_token'))){
            $this->entityManager->remove($planif);
            $this->entityManager->flush();
            $this->addFlash('succes', 'la planification a bien été supprimée');
        }
        return $this->redirectToRoute('admin.planifs.index');
    }

}