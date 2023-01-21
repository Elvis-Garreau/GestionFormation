<?php


namespace App\Controller;


use App\Entity\EnqueteChaud;
use App\Entity\EnqueteClient;
use App\Entity\EnqueteFroid;
use App\Entity\Planif;
use App\Entity\Stagiaire;
use App\Form\EnqueteChaudType;
use App\Form\EnqueteClientType;
use App\Form\EnqueteFroidType;
use App\Repository\EnqueteChaudRepository;
use App\Repository\EnqueteClientRepository;
use App\Repository\EnqueteFroidRepository;
use App\Repository\PlanifRepository;
use App\Repository\StagiaireRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EnquetesController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var StagiaireRepository
     */
    private $stagiaireRepository;
    /**
     * @var PlanifRepository
     */
    private $planifRepository;
    /**
     * @var EnqueteChaudRepository
     */
    private $enqueteChaudRepository;
    /**
     * @var EnqueteFroidRepository
     */
    private $enqueteFroidRepository;
    /**
     * @var EnqueteClientRepository
     */
    private $enqueteClientRepository;

    public function __construct(StagiaireRepository $stagiaireRepository, PlanifRepository $planifRepository, EnqueteChaudRepository $enqueteChaudRepository, EnqueteFroidRepository $enqueteFroidRepository, EnqueteClientRepository $enqueteClientRepository, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->stagiaireRepository = $stagiaireRepository;
        $this->planifRepository = $planifRepository;
        $this->enqueteChaudRepository = $enqueteChaudRepository;
        $this->enqueteFroidRepository = $enqueteFroidRepository;
        $this->enqueteClientRepository = $enqueteClientRepository;
    }

    /**
     * @Route("/enquetes-merci/{id}", name="enquete.merci", methods="GET|POST")
     * @param Stagiaire $stagiaire
     * @return Response
     */
    public function merci(Stagiaire $stagiaire): Response
    {
        return $this->render('enquetes/merci.html.twig', [
            'stagiaire' => $stagiaire
        ]);
    }

    /**
     * @Route("/enquetes-client-merci/{id}", name="enquete.client.merci", methods="GET|POST")
     * @param Planif $planif
     * @return Response
     */
    public function merciClient(Planif $planif): Response
    {
        return $this->render('enquetes/merci-client.html.twig', [
            'planif' => $planif
        ]);
    }

    /**
     * @Route("/enquetes-a-chaud-deja-rendue/{id}", name="enquete.chaud.remplie", methods="GET|POST")
     * @param Stagiaire $stagiaire
     * @return Response
     */
    public function remplieChaud(Stagiaire $stagiaire): Response
    {
        return $this->render('enquetes/remplie-chaud.html.twig', [
            'stagiaire' => $stagiaire
        ]);
    }

    /**
     * @Route("/enquetes-a-froid-deja-rendue/{id}", name="enquete.froid.remplie", methods="GET|POST")
     * @param Stagiaire $stagiaire
     * @return Response
     */
    public function remplieFroid(Stagiaire $stagiaire): Response
    {
        return $this->render('enquetes/remplie-froid.html.twig', [
            'stagiaire' => $stagiaire
        ]);
    }

    /**
     * @Route("/enquetes-client-deja-rendue/{id}", name="enquete.client.remplie", methods="GET|POST")
     * @param Planif $planif
     * @return Response
     */
    public function remplieClient(Planif $planif): Response
    {
        return $this->render('enquetes/remplie-client.html.twig', [
            'planif' => $planif
        ]);
    }

    /**
     * @Route("/enquete-a-chaud/{planifId}-{stagiaireId}", name="enquete.chaud.form", methods="GET|POST")
     * @param $planifId
     * @param $stagiaireId
     * @param Request $request
     * @return Response
     */
    public function enqueteChaud($planifId, $stagiaireId, Request $request): Response
    {
        $stagiaire = $this->stagiaireRepository->find($stagiaireId);
        $planif = $this->planifRepository->find($planifId);

        $verifStagiaire = $this->enqueteChaudRepository->countByStagiaire($stagiaireId);

        if ($verifStagiaire > 0){
            return $this->redirectToRoute('enquete.chaud.remplie', [
                'id' => $stagiaireId
            ]);
        }

        $enquete = new EnqueteChaud();

        $form = $this->createForm(EnqueteChaudType::class, $enquete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $enquete->setPlanif($planif);
            $enquete->setStagiaire($stagiaire);
            $enquete->setCreatedAt(new DateTime('now'));
            $this->entityManager->persist($enquete);
            $this->entityManager->flush();
            return $this->redirectToRoute('enquete.merci', ['id' => $stagiaireId]);
        }

        return $this->render('enquetes/chaud.html.twig', [
            'planif' => $planif,
            'stagiaire' => $stagiaire,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/enquete-a-froid/{planifId}-{stagiaireId}", name="enquete.froid.form", methods="GET|POST")
     * @param $planifId
     * @param $stagiaireId
     * @param Request $request
     * @return Response
     */
    public function enqueteFroid($planifId, $stagiaireId, Request $request): Response
    {
        $stagiaire = $this->stagiaireRepository->find($stagiaireId);
        $planif = $this->planifRepository->find($planifId);

        $verifStagiaire = $this->enqueteFroidRepository->countByStagiaire($stagiaireId);

        if ($verifStagiaire > 0){
            return $this->redirectToRoute('enquete.froid.remplie', [
                'id' => $stagiaireId
            ]);
        }

        $enquete = new EnqueteFroid();

        $form = $this->createForm(EnqueteFroidType::class, $enquete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $enquete->setPlanif($planif);
            $enquete->setStagiaire($stagiaire);
            $enquete->setCreatedAt(new DateTime('now'));
            $this->entityManager->persist($enquete);
            $this->entityManager->flush();
            return $this->redirectToRoute('enquete.merci', ['id' => $stagiaireId]);
        }

        return $this->render('enquetes/froid.html.twig', [
            'planif' => $planif,
            'stagiaire' => $stagiaire,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/enquete-client/{planifId}", name="enquete.client.form", methods="GET|POST")
     * @param $planifId
     * @param Request $request
     * @return Response
     */
    public function enqueteClient($planifId, Request $request): Response
    {
        $planif = $this->planifRepository->find($planifId);

        $verifPlanif = $this->enqueteClientRepository->countByplanif($planifId);

        if ($verifPlanif > 0){
            return $this->redirectToRoute('enquete.client.remplie', [
                'id' => $planifId
            ]);
        }

        $enquete = new EnqueteClient();

        $form = $this->createForm(EnqueteClientType::class, $enquete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $enquete->setPlanif($planif);
            $enquete->setCreatedAt(new DateTime('now'));
            $this->entityManager->persist($enquete);
            $this->entityManager->flush();
            return $this->redirectToRoute('enquete.client.merci', ['id' => $planifId]);
        }

        return $this->render('enquetes/client.html.twig', [
            'planif' => $planif,
            'form' => $form->createView()
        ]);
    }

}