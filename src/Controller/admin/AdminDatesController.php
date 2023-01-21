<?php


namespace App\Controller\admin;


use App\Entity\Dates;
use App\Entity\Planif;
use App\Form\DatesType;
use App\Repository\DatesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDatesController Extends AbstractController
{

    /**
     * @var DatesRepository
     */
    private $datesRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(DatesRepository $datesRepository, EntityManagerInterface $entityManager)
    {
        $this->datesRepository = $datesRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/dates-admin/{id}", name="admin.dates.index", methods="GET|POST")
     * @param Planif $planif
     * @return Response
     */
    public function index(Planif $planif): Response
    {
        $dates = $this->datesRepository->findAllByPlanif($planif);

        $date_debut = $planif->getDates()->first()->getDateAnnee() . $planif->getDates()->first()->getDateMois() . $planif->getDates()->first()->getDateJour();
        $planif->setDateDebut($date_debut);
        $date_fin = $planif->getDates()->last()->getDateAnnee() . $planif->getDates()->last()->getDateMois() . $planif->getDates()->last()->getDateJour();
        $planif->setDateFin($date_fin);
        $this->entityManager->persist($planif);
        $this->entityManager->flush();

        return $this->render('admin/dates/dates-gerer.html.twig', [
            'dates' => $dates,
            'planif' => $planif
        ]);
    }

    /**
     * @Route("/date-admin/new-{id}", name="admin.date.new")
     * @param Planif $planif
     * @param Request $request
     * @return Response
     */
    public function new(Planif $planif, Request $request): Response
    {
        $date = new Dates();

        $form = $this->createForm(DatesType::class, $date);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date->setPlanif($planif);
            $this->entityManager->persist($date);
            $this->entityManager->flush();
            $this->addFlash('succes', 'la date a bien été ajoutée');
            $planifId = $planif->getId();
            return $this->redirectToRoute('admin.dates.index', ['id' => $planifId]);
        }

        return $this->render('admin/dates/date-new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/date-admin/{id}", name="admin.date.edit", methods="GET|POST")
     * @param Dates $date
     * @param Request $request
     * @return Response
     */
    public function edit(Dates $date, Request $request): Response
    {
        $form = $this->createForm(DatesType::class, $date);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('succes', 'La date a bien été mise à jour');
            $planif = $date->getPlanif()->getId();
            return $this->redirectToRoute('admin.dates.index', ['id' => $planif]);
        }

        return $this->render('admin/dates/date-edit.html.twig', [
            'date' => $date,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/date-admin/{id}", name="admin.date.delete", methods="DELETE")
     * @param Dates $date
     * @param Request $request
     * @return Response
     */
    public function delete(Dates $date, Request $request): Response
    {
        if($this->isCsrfTokenValid('delete' . $date->getId(), $request->get('_token'))){
            $this->entityManager->remove($date);
            $this->entityManager->flush();
            $this->addFlash('succes', 'la date a bien été supprimée');
        }
        $planif = $date->getPlanif()->getId();
        return $this->redirectToRoute('admin.dates.index', ['id' => $planif]);
    }

}