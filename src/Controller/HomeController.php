<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Repository\FormateurRepository;
use App\Repository\FormationRepository;
use App\Repository\PlanifRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @var FormationRepository
     */
    private $formationRepository;
    /**
     * @var FormateurRepository
     */
    private $formateurRepository;
    /**
     * @var ClientRepository
     */
    private $clientRepository;
    /**
     * @var PlanifRepository
     */
    private $planifRepository;

    public function __construct(FormationRepository $formationRepository, FormateurRepository $formateurRepository, ClientRepository $clientRepository, PlanifRepository $planifRepository)
    {
        $this->formationRepository = $formationRepository;
        $this->formateurRepository = $formateurRepository;
        $this->clientRepository = $clientRepository;
        $this->planifRepository = $planifRepository;
    }

    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index(): Response
    {
        $organismeId = $this->getUser()->getOrganisme()->getId();

        $countFormations = $this->formationRepository->countByOrganisme($organismeId);
        $countFormateurs = $this->formateurRepository->countByOrganisme($organismeId);
        $countClients = $this->clientRepository->countByOrganisme($organismeId);
        $countPlanifs = $this->planifRepository->countByOrganisme($organismeId);

        $role = $this->getUser()->getRoleAdmin();

        if ($role == true){
            $status = 'administrateur';
        } else{
            $status = 'utilisateur';
        }

        return $this->render('pages/home.html.twig', [
            'status' => $status,
            'countFormations' => $countFormations,
            'countFormateurs' => $countFormateurs,
            'countClients' => $countClients,
            'countPlanifs' => $countPlanifs
        ]);
    }

}