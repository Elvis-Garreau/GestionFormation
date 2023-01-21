<?php


namespace App\Controller;


use App\Entity\PlanAction;
use App\Entity\Planif;
use App\Form\PlanActionType;
use App\Repository\EnqueteChaudRepository;
use App\Repository\EnqueteClientRepository;
use App\Repository\EnqueteFroidRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DepouillementController Extends AbstractController
{

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
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EnqueteChaudRepository $enqueteChaudRepository, EnqueteFroidRepository $enqueteFroidRepository, EnqueteClientRepository $enqueteClientRepository, EntityManagerInterface $entityManager)
    {
        $this->enqueteChaudRepository = $enqueteChaudRepository;
        $this->enqueteFroidRepository = $enqueteFroidRepository;
        $this->enqueteClientRepository = $enqueteClientRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/depouillement/{id}", name="depouillement")
     * @param Planif $planif
     * @param Request $request
     * @return Response
     */
    public function depouillement(Planif $planif, Request $request): Response
    {
        $totalEnqueteChaud = $this->enqueteChaudRepository->countByPlanif($planif);

        $totalEnqueteFroid = $this->enqueteFroidRepository->countByPlanif($planif);

        $totalEnquete = $totalEnqueteChaud + $totalEnqueteFroid;

        $enqueteClient = $this->enqueteClientRepository->findOneBy([
            'planif' => $planif
        ]);

        $totalDureeStageTroisChaud = $this->enqueteChaudRepository->countDureeStage($planif, 3);
        $totalDureeStageDeuxChaud = $this->enqueteChaudRepository->countDureeStage($planif, 2);
        $totalDureeStageUnChaud = $this->enqueteChaudRepository->countDureeStage($planif, 1);
        $totalDureeStageZeroChaud = $this->enqueteChaudRepository->countDureeStage($planif, 0);

        $totalDureeStageTroisFroid = $this->enqueteFroidRepository->countDureeStage($planif, 3);
        $totalDureeStageDeuxFroid = $this->enqueteFroidRepository->countDureeStage($planif, 2);
        $totalDureeStageUnFroid = $this->enqueteFroidRepository->countDureeStage($planif, 1);
        $totalDureeStageZeroFroid = $this->enqueteFroidRepository->countDureeStage($planif, 0);

        $arrayDureeStage = [$totalDureeStageZeroChaud + $totalDureeStageZeroFroid, $totalDureeStageUnChaud + $totalDureeStageUnFroid, $totalDureeStageDeuxChaud + $totalDureeStageDeuxFroid, $totalDureeStageTroisChaud + $totalDureeStageTroisFroid];

        $totalSupportFormationTroisChaud = $this->enqueteChaudRepository->countSupportFormation($planif, 3);
        $totalSupportFormationDeuxChaud = $this->enqueteChaudRepository->countSupportFormation($planif, 2);
        $totalSupportFormationUnChaud = $this->enqueteChaudRepository->countSupportFormation($planif, 1);
        $totalSupportFormationZeroChaud = $this->enqueteChaudRepository->countSupportFormation($planif, 0);

        $totalSupportFormationTroisFroid = $this->enqueteFroidRepository->countSupportFormation($planif, 3);
        $totalSupportFormationDeuxFroid = $this->enqueteFroidRepository->countSupportFormation($planif, 2);
        $totalSupportFormationUnFroid = $this->enqueteFroidRepository->countSupportFormation($planif, 1);
        $totalSupportFormationZeroFroid = $this->enqueteFroidRepository->countSupportFormation($planif, 0);

        $arraySupportFormation = [$totalSupportFormationZeroChaud + $totalSupportFormationZeroFroid, $totalSupportFormationUnChaud + $totalSupportFormationUnFroid, $totalSupportFormationDeuxChaud + $totalSupportFormationDeuxFroid, $totalSupportFormationTroisChaud + $totalSupportFormationTroisFroid];

        $totalFormateurClairTroisChaud = $this->enqueteChaudRepository->countFormateurClair($planif, 3);
        $totalFormateurClairDeuxChaud = $this->enqueteChaudRepository->countFormateurClair($planif, 2);
        $totalFormateurClairUnChaud = $this->enqueteChaudRepository->countFormateurClair($planif, 1);
        $totalFormateurClairZeroChaud = $this->enqueteChaudRepository->countFormateurClair($planif, 0);

        $totalFormateurClairTroisFroid = $this->enqueteFroidRepository->countFormateurClair($planif, 3);
        $totalFormateurClairDeuxFroid = $this->enqueteFroidRepository->countFormateurClair($planif, 2);
        $totalFormateurClairUnFroid = $this->enqueteFroidRepository->countFormateurClair($planif, 1);
        $totalFormateurClairZeroFroid = $this->enqueteFroidRepository->countFormateurClair($planif, 0);

        $arrayFormateurClair = [$totalFormateurClairZeroChaud + $totalFormateurClairZeroFroid, $totalFormateurClairUnChaud + $totalFormateurClairUnFroid, $totalFormateurClairDeuxChaud + $totalFormateurClairDeuxFroid, $totalFormateurClairTroisChaud + $totalFormateurClairTroisFroid];

        $totalFormateurAdapteTroisChaud = $this->enqueteChaudRepository->countFormateurAdapte($planif, 3);
        $totalFormateurAdapteDeuxChaud = $this->enqueteChaudRepository->countFormateurAdapte($planif, 2);
        $totalFormateurAdapteUnChaud = $this->enqueteChaudRepository->countFormateurAdapte($planif, 1);
        $totalFormateurAdapteZeroChaud = $this->enqueteChaudRepository->countFormateurAdapte($planif, 0);

        $totalFormateurAdapteTroisFroid = $this->enqueteFroidRepository->countFormateurAdapte($planif, 3);
        $totalFormateurAdapteDeuxFroid = $this->enqueteFroidRepository->countFormateurAdapte($planif, 2);
        $totalFormateurAdapteUnFroid = $this->enqueteFroidRepository->countFormateurAdapte($planif, 1);
        $totalFormateurAdapteZeroFroid = $this->enqueteFroidRepository->countFormateurAdapte($planif, 0);

        $arrayFormateurAdapte = [$totalFormateurAdapteZeroChaud + $totalFormateurAdapteZeroFroid, $totalFormateurAdapteUnChaud + $totalFormateurAdapteUnFroid, $totalFormateurAdapteDeuxChaud + $totalFormateurAdapteDeuxFroid, $totalFormateurAdapteTroisChaud + $totalFormateurAdapteTroisFroid];

        $arrayOrganisation = [$totalDureeStageZeroChaud + $totalDureeStageZeroFroid + $totalSupportFormationZeroChaud + $totalSupportFormationZeroFroid + $totalFormateurClairZeroChaud + $totalFormateurClairZeroFroid + $totalFormateurAdapteZeroChaud + $totalFormateurAdapteZeroFroid, $totalDureeStageUnChaud + $totalDureeStageUnFroid + $totalSupportFormationUnChaud + $totalSupportFormationUnFroid + $totalFormateurClairUnChaud + $totalFormateurClairUnFroid + $totalFormateurAdapteUnChaud + $totalFormateurAdapteUnFroid, $totalDureeStageDeuxChaud + $totalDureeStageDeuxFroid + $totalSupportFormationDeuxChaud + $totalSupportFormationDeuxFroid + $totalFormateurClairDeuxChaud + $totalFormateurClairDeuxFroid + $totalFormateurAdapteDeuxChaud + $totalFormateurAdapteDeuxFroid, $totalDureeStageTroisChaud + $totalDureeStageTroisFroid + $totalSupportFormationTroisChaud + $totalSupportFormationTroisFroid + $totalFormateurClairTroisChaud + $totalFormateurClairTroisFroid + $totalFormateurAdapteTroisChaud + $totalFormateurAdapteTroisFroid];

        $totalProgrammeClairTroisChaud = $this->enqueteChaudRepository->countProgrammeClair($planif, 3);
        $totalProgrammeClairDeuxChaud = $this->enqueteChaudRepository->countProgrammeClair($planif, 2);
        $totalProgrammeClairUnChaud = $this->enqueteChaudRepository->countProgrammeClair($planif, 1);
        $totalProgrammeClairZeroChaud = $this->enqueteChaudRepository->countProgrammeClair($planif, 0);

        $totalProgrammeClairTroisFroid = $this->enqueteFroidRepository->countProgrammeClair($planif, 3);
        $totalProgrammeClairDeuxFroid = $this->enqueteFroidRepository->countProgrammeClair($planif, 2);
        $totalProgrammeClairUnFroid = $this->enqueteFroidRepository->countProgrammeClair($planif, 1);
        $totalProgrammeClairZeroFroid = $this->enqueteFroidRepository->countProgrammeClair($planif, 0);

        $arrayProgrammeClair = [$totalProgrammeClairZeroChaud + $totalProgrammeClairZeroFroid, $totalProgrammeClairUnChaud + $totalProgrammeClairUnFroid, $totalProgrammeClairDeuxChaud + $totalProgrammeClairDeuxFroid, $totalProgrammeClairTroisChaud + $totalProgrammeClairTroisFroid];

        $totalProgrammeAdapteTroisChaud = $this->enqueteChaudRepository->countProgrammeAdapte($planif, 3);
        $totalProgrammeAdapteDeuxChaud = $this->enqueteChaudRepository->countProgrammeAdapte($planif, 2);
        $totalProgrammeAdapteUnChaud = $this->enqueteChaudRepository->countProgrammeAdapte($planif, 1);
        $totalProgrammeAdapteZeroChaud = $this->enqueteChaudRepository->countProgrammeAdapte($planif, 0);

        $totalProgrammeAdapteTroisFroid = $this->enqueteFroidRepository->countProgrammeAdapte($planif, 3);
        $totalProgrammeAdapteDeuxFroid = $this->enqueteFroidRepository->countProgrammeAdapte($planif, 2);
        $totalProgrammeAdapteUnFroid = $this->enqueteFroidRepository->countProgrammeAdapte($planif, 1);
        $totalProgrammeAdapteZeroFroid = $this->enqueteFroidRepository->countProgrammeAdapte($planif, 0);

        $arrayProgrammeAdapte = [$totalProgrammeAdapteZeroChaud + $totalProgrammeAdapteZeroFroid, $totalProgrammeAdapteUnChaud + $totalProgrammeAdapteUnFroid, $totalProgrammeAdapteDeuxChaud + $totalProgrammeAdapteDeuxFroid, $totalProgrammeAdapteTroisChaud + $totalProgrammeAdapteTroisFroid];

        $totalObjectifFormationTroisChaud = $this->enqueteChaudRepository->countObjectifFormation($planif, 3);
        $totalObjectifFormationDeuxChaud = $this->enqueteChaudRepository->countObjectifFormation($planif, 2);
        $totalObjectifFormationUnChaud = $this->enqueteChaudRepository->countObjectifFormation($planif, 1);
        $totalObjectifFormationZeroChaud = $this->enqueteChaudRepository->countObjectifFormation($planif, 0);

        $totalObjectifFormationTroisFroid = $this->enqueteFroidRepository->countObjectifFormation($planif, 3);
        $totalObjectifFormationDeuxFroid = $this->enqueteFroidRepository->countObjectifFormation($planif, 2);
        $totalObjectifFormationUnFroid = $this->enqueteFroidRepository->countObjectifFormation($planif, 1);
        $totalObjectifFormationZeroFroid = $this->enqueteFroidRepository->countObjectifFormation($planif, 0);

        $arrayObjectifFormation = [$totalObjectifFormationZeroChaud + $totalObjectifFormationZeroFroid, $totalObjectifFormationUnChaud + $totalObjectifFormationUnFroid, $totalObjectifFormationDeuxChaud + $totalObjectifFormationDeuxFroid, $totalObjectifFormationTroisChaud + $totalObjectifFormationTroisFroid];

        $totalComprisObjectifTroisChaud = $this->enqueteChaudRepository->countComprisObjectif($planif, 3);
        $totalComprisObjectifDeuxChaud = $this->enqueteChaudRepository->countComprisObjectif($planif, 2);
        $totalComprisObjectifUnChaud = $this->enqueteChaudRepository->countComprisObjectif($planif, 1);
        $totalComprisObjectifZeroChaud = $this->enqueteChaudRepository->countComprisObjectif($planif, 0);

        $totalComprisObjectifTroisFroid = $this->enqueteFroidRepository->countComprisObjectif($planif, 3);
        $totalComprisObjectifDeuxFroid = $this->enqueteFroidRepository->countComprisObjectif($planif, 2);
        $totalComprisObjectifUnFroid = $this->enqueteFroidRepository->countComprisObjectif($planif, 1);
        $totalComprisObjectifZeroFroid = $this->enqueteFroidRepository->countComprisObjectif($planif, 0);

        $arrayComprisObjectif = [$totalComprisObjectifZeroChaud + $totalComprisObjectifZeroFroid, $totalComprisObjectifUnChaud + $totalComprisObjectifUnFroid, $totalComprisObjectifDeuxChaud + $totalComprisObjectifDeuxFroid, $totalComprisObjectifTroisChaud + $totalComprisObjectifTroisFroid];

        $totalExercicesPertinentsTroisChaud = $this->enqueteChaudRepository->countExercicesPertinents($planif, 3);
        $totalExercicesPertinentsDeuxChaud = $this->enqueteChaudRepository->countExercicesPertinents($planif, 2);
        $totalExercicesPertinentsUnChaud = $this->enqueteChaudRepository->countExercicesPertinents($planif, 1);
        $totalExercicesPertinentsZeroChaud = $this->enqueteChaudRepository->countExercicesPertinents($planif, 0);

        $totalExercicesPertinentsTroisFroid = $this->enqueteFroidRepository->countExercicesPertinents($planif, 3);
        $totalExercicesPertinentsDeuxFroid = $this->enqueteFroidRepository->countExercicesPertinents($planif, 2);
        $totalExercicesPertinentsUnFroid = $this->enqueteFroidRepository->countExercicesPertinents($planif, 1);
        $totalExercicesPertinentsZeroFroid = $this->enqueteFroidRepository->countExercicesPertinents($planif, 0);

        $arrayExercicesPertinents = [$totalExercicesPertinentsZeroChaud + $totalExercicesPertinentsZeroFroid, $totalExercicesPertinentsUnChaud + $totalExercicesPertinentsUnFroid, $totalExercicesPertinentsDeuxChaud + $totalExercicesPertinentsDeuxFroid, $totalExercicesPertinentsTroisChaud + $totalExercicesPertinentsTroisFroid];

        $totalCompetencesAmelioreesTroisChaud = $this->enqueteChaudRepository->countCompetencesAmeliorees($planif, 3);
        $totalCompetencesAmelioreesDeuxChaud = $this->enqueteChaudRepository->countCompetencesAmeliorees($planif, 2);
        $totalCompetencesAmelioreesUnChaud = $this->enqueteChaudRepository->countCompetencesAmeliorees($planif, 1);
        $totalCompetencesAmelioreesZeroChaud = $this->enqueteChaudRepository->countCompetencesAmeliorees($planif, 0);

        $totalCompetencesAmelioreesTroisFroid = $this->enqueteFroidRepository->countCompetencesAmeliorees($planif, 3);
        $totalCompetencesAmelioreesDeuxFroid = $this->enqueteFroidRepository->countCompetencesAmeliorees($planif, 2);
        $totalCompetencesAmelioreesUnFroid = $this->enqueteFroidRepository->countCompetencesAmeliorees($planif, 1);
        $totalCompetencesAmelioreesZeroFroid = $this->enqueteFroidRepository->countCompetencesAmeliorees($planif, 0);

        $arrayCompetencesAmeliorees = [$totalCompetencesAmelioreesZeroChaud + $totalCompetencesAmelioreesZeroFroid, $totalCompetencesAmelioreesUnChaud + $totalCompetencesAmelioreesUnFroid, $totalCompetencesAmelioreesDeuxChaud + $totalCompetencesAmelioreesDeuxFroid, $totalCompetencesAmelioreesTroisChaud + $totalCompetencesAmelioreesTroisFroid];

        $arrayDeroulementComprehension = [$totalProgrammeClairZeroChaud + $totalProgrammeClairZeroFroid + $totalProgrammeAdapteZeroChaud + $totalProgrammeAdapteZeroFroid + $totalObjectifFormationZeroChaud + $totalObjectifFormationZeroFroid + $totalComprisObjectifZeroChaud + $totalComprisObjectifZeroFroid + $totalExercicesPertinentsZeroChaud + $totalExercicesPertinentsZeroFroid + $totalCompetencesAmelioreesZeroChaud + $totalCompetencesAmelioreesZeroFroid, $totalProgrammeClairUnChaud + $totalProgrammeClairUnFroid + $totalProgrammeAdapteUnChaud + $totalProgrammeAdapteUnFroid + $totalObjectifFormationUnChaud + $totalObjectifFormationUnFroid + $totalComprisObjectifUnChaud + $totalComprisObjectifUnFroid + $totalExercicesPertinentsUnChaud + $totalExercicesPertinentsUnFroid + $totalCompetencesAmelioreesUnChaud + $totalCompetencesAmelioreesUnFroid, $totalProgrammeClairDeuxChaud + $totalProgrammeClairDeuxFroid + $totalProgrammeAdapteDeuxChaud + $totalProgrammeAdapteDeuxFroid + $totalObjectifFormationDeuxChaud + $totalObjectifFormationDeuxFroid + $totalComprisObjectifDeuxChaud + $totalComprisObjectifDeuxFroid + $totalExercicesPertinentsDeuxChaud + $totalExercicesPertinentsDeuxFroid + $totalCompetencesAmelioreesDeuxChaud + $totalCompetencesAmelioreesDeuxFroid, $totalProgrammeClairTroisChaud + $totalProgrammeClairTroisFroid + $totalProgrammeAdapteTroisChaud + $totalProgrammeAdapteTroisFroid + $totalObjectifFormationTroisChaud + $totalObjectifFormationTroisFroid + $totalComprisObjectifTroisChaud + $totalComprisObjectifTroisFroid + $totalExercicesPertinentsTroisChaud + $totalExercicesPertinentsTroisFroid + $totalCompetencesAmelioreesTroisChaud + $totalCompetencesAmelioreesTroisFroid];

        $totalConditionAccueilTroisChaud = $this->enqueteChaudRepository->countConditionAccueil($planif, 3);
        $totalConditionAccueilDeuxChaud = $this->enqueteChaudRepository->countConditionAccueil($planif, 2);
        $totalConditionAccueilUnChaud = $this->enqueteChaudRepository->countConditionAccueil($planif, 1);
        $totalConditionAccueilZeroChaud = $this->enqueteChaudRepository->countConditionAccueil($planif, 0);

        $totalConditionAccueilTroisFroid = $this->enqueteFroidRepository->countConditionAccueil($planif, 3);
        $totalConditionAccueilDeuxFroid = $this->enqueteFroidRepository->countConditionAccueil($planif, 2);
        $totalConditionAccueilUnFroid = $this->enqueteFroidRepository->countConditionAccueil($planif, 1);
        $totalConditionAccueilZeroFroid = $this->enqueteFroidRepository->countConditionAccueil($planif, 0);

        $arrayConditionAccueil = [$totalConditionAccueilZeroChaud + $totalConditionAccueilZeroFroid, $totalConditionAccueilUnChaud + $totalConditionAccueilUnFroid, $totalConditionAccueilDeuxChaud + $totalConditionAccueilDeuxFroid, $totalConditionAccueilTroisChaud + $totalConditionAccueilTroisFroid];

        $totalApprecieGlobalTroisChaud = $this->enqueteChaudRepository->countApprecieGlobal($planif, 3);
        $totalApprecieGlobalDeuxChaud = $this->enqueteChaudRepository->countApprecieGlobal($planif, 2);
        $totalApprecieGlobalUnChaud = $this->enqueteChaudRepository->countApprecieGlobal($planif, 1);
        $totalApprecieGlobalZeroChaud = $this->enqueteChaudRepository->countApprecieGlobal($planif, 0);

        $totalApprecieGlobalTroisFroid = $this->enqueteFroidRepository->countApprecieGlobal($planif, 3);
        $totalApprecieGlobalDeuxFroid = $this->enqueteFroidRepository->countApprecieGlobal($planif, 2);
        $totalApprecieGlobalUnFroid = $this->enqueteFroidRepository->countApprecieGlobal($planif, 1);
        $totalApprecieGlobalZeroFroid = $this->enqueteFroidRepository->countApprecieGlobal($planif, 0);

        $arrayApprecieGlobal = [$totalApprecieGlobalZeroChaud + $totalApprecieGlobalZeroFroid, $totalApprecieGlobalUnChaud + $totalApprecieGlobalUnFroid, $totalApprecieGlobalDeuxChaud + $totalApprecieGlobalDeuxFroid, $totalApprecieGlobalTroisChaud + $totalApprecieGlobalTroisFroid];

        $totalRecommandeUnChaud = $this->enqueteChaudRepository->countRecommande($planif, 1);
        $totalRecommandeZeroChaud = $this->enqueteChaudRepository->countRecommande($planif, 0);

        $totalRecommandeUnFroid = $this->enqueteFroidRepository->countRecommande($planif, 1);
        $totalRecommandeZeroFroid = $this->enqueteFroidRepository->countRecommande($planif, 0);

        $arrayRecommande = [$totalRecommandeZeroChaud + $totalRecommandeZeroFroid, $totalRecommandeUnChaud + $totalRecommandeUnFroid];

        $planAction = new PlanAction();
        $form = $this->createForm(PlanActionType::class, $planAction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $planAction->setPlanif($planif);
            $this->entityManager->persist($planAction);
            $this->entityManager->flush();
            $this->addFlash('succes', 'le plan d\'action a bien été créé');
            $planifId = $planif->getId();
            return $this->redirectToRoute('depouillement', ['id' => $planifId]);
        }

        return $this->render('pages/depouillement.html.twig', [
            'TotalEnqueteChaud' => $totalEnqueteChaud,
            'TotalEnqueteFroid' => $totalEnqueteFroid,
            'TotalEnquete' => $totalEnquete,
            'planif' => $planif,
            'DureeStage' => $arrayDureeStage,
            'SupportFormation' => $arraySupportFormation,
            'FormateurClair' => $arrayFormateurClair,
            'FormateurAdapte' => $arrayFormateurAdapte,
            'Organisation' => $arrayOrganisation,
            'ProgrammeClair' => $arrayProgrammeClair,
            'ProgrammeAdapte' => $arrayProgrammeAdapte,
            'ObjectifFormation' => $arrayObjectifFormation,
            'ComprisObjectif' => $arrayComprisObjectif,
            'ExercicesPertinents' => $arrayExercicesPertinents,
            'CompetencesAmeliorees' => $arrayCompetencesAmeliorees,
            'DeroulementComprehension' => $arrayDeroulementComprehension,
            'ConditionAccueil' => $arrayConditionAccueil,
            'ApprecieGlobal' => $arrayApprecieGlobal,
            'Recommande' => $arrayRecommande,
            'EnqueteClient' => $enqueteClient,
            'form' => $form->createView()
        ]);
    }

}