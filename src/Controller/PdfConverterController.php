<?php


namespace App\Controller;

use App\Entity\Formation;
use App\Entity\Organisme;
use App\Entity\PlanAction;
use App\Entity\Planif;
use App\Repository\DatesRepository;
use App\Repository\EnqueteChaudRepository;
use App\Repository\EnqueteClientRepository;
use App\Repository\EnqueteFroidRepository;
use App\Repository\PlanActionRepository;
use App\Repository\PlanifRepository;
use App\Repository\StagiaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\Process;
use Symfony\Component\Routing\Annotation\Route;

class PdfConverterController extends AbstractController
{

    /**
     * @var PlanifRepository
     */
    private $planifRepository;
    /**
     * @var StagiaireRepository
     */
    private $stagiaireRepository;
    /**
     * @var DatesRepository
     */
    private $datesRepository;
    /**
     * @var PlanActionRepository
     */
    private $planActionRepository;
    /**
     * @var EnqueteClientRepository
     */
    private $enqueteClientRepository;
    /**
     * @var EnqueteFroidRepository
     */
    private $enqueteFroidRepository;
    /**
     * @var EnqueteChaudRepository
     */
    private $enqueteChaudRepository;

    public function __construct(PlanifRepository $planifRepository, StagiaireRepository $stagiaireRepository, DatesRepository  $datesRepository, PlanActionRepository $planActionRepository, EnqueteClientRepository $enqueteClientRepository, EnqueteFroidRepository $enqueteFroidRepository, EnqueteChaudRepository $enqueteChaudRepository)
    {
        $this->planifRepository = $planifRepository;
        $this->stagiaireRepository = $stagiaireRepository;
        $this->datesRepository = $datesRepository;
        $this->planActionRepository = $planActionRepository;
        $this->enqueteClientRepository = $enqueteClientRepository;
        $this->enqueteFroidRepository = $enqueteFroidRepository;
        $this->enqueteChaudRepository = $enqueteChaudRepository;
    }

    /**
     * @Route("/convert-planif/{id}", name="convert-planif", methods="CONVERT")
     * @param Planif $planif
     * @return Response
     */
    public function convert(Planif $planif)
    {

            $id = $planif->getId();
            $date = $planif->getDates()->first()->getDateAnnee() . $planif->getDates()->first()->getDateMois() . $planif->getDates()->first()->getDateJour();
            $of = $planif->getOrganisme()->getSlug();

            $organismeId = $planif->getOrganisme()->getId();

            $mkdirOf = new Process(['mkdir', 'convert/' . $of]);
            $mkdirOf->run();

            $mkdirPlanif = new Process(['mkdir', 'convert/' . $of . '/' . $date . $id]);
            $mkdirPlanif->run();

            $convention = new Process([
                'wkhtmltopdf',
                '--footer-html', 'http://formabil.fr/convert-footer/' . $organismeId,
                '-T', '30px',
                '-L', '30px',
                '-B', '80px',
                '-R', '30px',
                'http://formabil.fr/convert-convention/' . $id,
                'convert/' . $of . '/' . $date . $id . '/' . $date . $id . '-convention.pdf'
            ]);
            $convention->run();

            $programme = new Process([
                'wkhtmltopdf',
                '--footer-html', 'http://formabil.fr/convert-footer/' . $organismeId,
                '-T', '30px',
                '-L', '30px',
                '-B', '80px',
                '-R', '30px',
                'http://formabil.fr/convert-programme/' . $id,
                'convert/' . $of . '/' . $date . $id . '/' . $date . $id . '-programme.pdf'
            ]);
            $programme->run();

            $dates = $planif->getDates();

            foreach ($dates as $jour)
            {
                $formaDate = $jour->getDateJour() . '-' . $jour->getDateMois() . '-' . $jour->getDateAnnee();
                $idDate = $jour->getId();

                $emargement = new Process([
                    'wkhtmltopdf',
                    '--footer-html', 'http://formabil.fr/convert-footer/' . $organismeId,
                    '-T', '30px',
                    '-L', '30px',
                    '-B', '80px',
                    '-R', '30px',
                    'http://formabil.fr/convert-emargement/' . $id . '-' . $idDate,
                    'convert/' . $of . '/' . $date . $id . '/' . $date . $id . '-emargement-' . $formaDate . '.pdf'
                ]);
                $emargement->mustRun();


            }

            $stagiaires = $planif->getStagiaires();

            foreach ($stagiaires as $stagiaire)
            {
                $idSt = $stagiaire->getId();
                $nomStagaire = $stagiaire->getNom() . '-' . $stagiaire->getPrenom();

                $attestationPresence = new Process([
                    'wkhtmltopdf',
                    '--footer-html', 'http://formabil.fr/convert-footer/' . $organismeId,
                    '-T', '30px',
                    '-L', '30px',
                    '-B', '80px',
                    '-R', '30px',
                    'http://formabil.fr/convert-attest-presence/' . $id . '-' . $idSt,
                    'convert/' . $of . '/' . $date . $id . '/' . $date . $id . '-' . $nomStagaire . '-attestation-presence.pdf'
                ]);
                $attestationPresence->mustRun();

                $convocation = new Process([
                    'wkhtmltopdf',
                    '--footer-html', 'http://formabil.fr/convert-footer/' . $organismeId,
                    '-T', '30px',
                    '-L', '30px',
                    '-B', '80px',
                    '-R', '30px',
                    'http://formabil.fr/convert-convocation/' . $id . '-' . $idSt,
                    'convert/' . $of . '/' . $date . $id . '/' . $date . $id . '-' . $nomStagaire . '-convocation.pdf'
                ]);
                $convocation->mustRun();
            }

        return $this->redirectToRoute('planif.finder', ['id' => $id]);
    }

    /**
     * @Route("/convert-planif-enquetes/{id}", name="convert-planif-enquetes", methods="CONVERT")
     * @param Planif $planif
     * @return Response
     */
    public function convertEnquete(Planif $planif)
    {

        $id = $planif->getId();
        $date = $planif->getDates()->first()->getDateAnnee() . $planif->getDates()->first()->getDateMois() . $planif->getDates()->first()->getDateJour();
        $of = $planif->getOrganisme()->getSlug();

        $organismeId = $planif->getOrganisme()->getId();

        $mkdirOf = new Process(['mkdir', 'convert/' . $of]);
        $mkdirOf->run();

        $mkdirPlanif = new Process(['mkdir', 'convert/' . $of . '/' . $date . $id]);
        $mkdirPlanif->run();

            $depouillement = new Process([
                'wkhtmltopdf',
                '--footer-html', 'http://formabil.fr/convert-footer/' . $organismeId,
                '-T', '30px',
                '-L', '30px',
                '-B', '80px',
                '-R', '30px',
                'http://formabil.fr/convert-depouillement/' . $id,
                'convert/' . $of . '/' . $date . $id . '/' . $date . $id . '-depouillement.pdf'
            ]);
            $depouillement->run();

            $enqueteClient = new Process([
                'wkhtmltopdf',
                '--footer-html', 'http://formabil.fr/convert-footer/' . $organismeId,
                '-T', '30px',
                '-L', '30px',
                '-B', '80px',
                '-R', '30px',
                'http://formabil.fr/convert-enquete-client/' . $id,
                'convert/' . $of . '/' . $date . $id . '/' . $date . $id . '-enquete-client.pdf'
            ]);
            $enqueteClient->run();

            $stagiaires = $planif->getStagiaires();

            foreach ($stagiaires as $stagiaire)
            {
                $idSt = $stagiaire->getId();
                $nomStagaire = $stagiaire->getNom() . '-' . $stagiaire->getPrenom();


                $enqueteFroid = new Process([
                    'wkhtmltopdf',
                    '--footer-html', 'http://formabil.fr/convert-footer/' . $organismeId,
                    '-T', '30px',
                    '-L', '30px',
                    '-B', '80px',
                    '-R', '30px',
                    'http://formabil.fr/convert-enquete-froid/' . $id . '-' . $idSt,
                    'convert/' . $of . '/' . $date . $id . '/' . $date . $id . '-' . $nomStagaire . '-enquete-a-froid.pdf'
                ]);
                $enqueteFroid->mustRun();

                $enqueteChaud = new Process([
                    'wkhtmltopdf',
                    '--footer-html', 'http://formabil.fr/convert-footer/' . $organismeId,
                    '-T', '30px',
                    '-L', '30px',
                    '-B', '80px',
                    '-R', '30px',
                    'http://formabil.fr/convert-enquete-chaud/' . $id . '-' . $idSt,
                    'convert/' . $of . '/' . $date . $id . '/' . $date . $id . '-' . $nomStagaire . '-enquete-a-chaud.pdf'
                ]);
                $enqueteChaud->mustRun();
            }

        return $this->redirectToRoute('planif.finder', ['id' => $id]);
    }

    /**
     * @Route("/convert-progamme-inscription/{id}", name="convert-programme-inscription", methods="CONVERT")
     * @param Formation $formation
     * @return Response
     */
    public function convertProgramme(Formation $formation): Response
    {

        $id = $formation->getId();
        $nom = $formation->getSlug();
        $of = $formation->getOrganisme()->getSlug();
        $organismeId = $formation->getOrganisme()->getId();

        $mkdirOf = new Process(['mkdir', 'convert/' . $of]);
        $mkdirOf->run();

        $mkdirFormation = new Process(['mkdir', 'convert/' . $of . '/' . $nom . $id]);
        $mkdirFormation->run();

            $programme = new Process([
                'wkhtmltopdf',
                '--footer-html', 'http://formabil.fr/convert-footer/' . $organismeId,
                '-T', '30px',
                '-L', '30px',
                '-B', '80px',
                '-R', '30px',
                'http://formabil.fr/convert-programme-amont/' . $id,
                'convert/' . $of . '/' . $nom . $id . '/' . $nom . $id . '-programme.pdf'
            ]);
            $programme->run();

            $inscriptionClient = new Process([
                'wkhtmltopdf',
                '--footer-html', 'http://formabil.fr/convert-footer/' . $organismeId,
                '-T', '30px',
                '-L', '30px',
                '-B', '80px',
                '-R', '30px',
                'http://formabil.fr/convert-inscription-client/' . $id,
                'convert/' . $of . '/' . $nom . $id . '/' . $nom . $id . '-inscription-client.pdf'
            ]);
            $inscriptionClient->run();

            $inscriptionStagiaire = new Process([
                'wkhtmltopdf',
                '--footer-html', 'http://formabil.fr/convert-footer/' . $organismeId,
                '-T', '30px',
                '-L', '30px',
                '-B', '80px',
                '-R', '30px',
                'http://formabil.fr/convert-inscription-stagiaire/' . $id,
                'convert/' . $of . '/' . $nom . $id . '/' . $nom . $id . '-inscription-stagiaire.pdf'
            ]);
            $inscriptionStagiaire->run();

        return $this->redirectToRoute('formation.show', ['id' => $id, 'slug' => $nom]);
    }

    /**
     * @Route("/convert-convention/{id}", name="convert.convention", methods="GET|POST")
     * @param Planif $planif
     */
    public function convention(Planif $planif)
    {
        $id = $planif->getId();
        $date = $planif->getDates()->first()->getDateAnnee() . $planif->getDates()->first()->getDateMois() . $planif->getDates()->first()->getDateJour();
        $refdossier = $date . $id;

        return $this->render('convert/convention.html.twig', [
            'planif' => $planif,
            'refdossier' => $refdossier
        ]);
    }

    /**
     * @Route("/convert-emargement/{id}-{idDate}", name="convert.emargement", methods="GET|POST")
     */
    public function emargement(int $id, int $idDate)
    {
        $planif = $this->planifRepository->find($id);
        $date = $this->datesRepository->find($idDate);

        $dates = $planif->getDates()->first()->getDateAnnee() . $planif->getDates()->first()->getDateMois() . $planif->getDates()->first()->getDateJour();
        $refdossier = $dates . $id;

        return $this->render('convert/emargement.html.twig', [
            'planif' => $planif,
            'date' => $date,
            'refdossier' => $refdossier
        ]);
    }

    /**
     * @Route("/convert-attest-presence/{id}-{idSt}", name="convert.attest.presence", methods="GET|POST")
     */
    public function attestPresence(int $id, int $idSt)
    {
        $planif = $this->planifRepository->find($id);
        $stagiaire = $this->stagiaireRepository->find($idSt);

        $date = $planif->getDates()->first()->getDateAnnee() . $planif->getDates()->first()->getDateMois() . $planif->getDates()->first()->getDateJour();
        $refdossier = $date . $id;

        return $this->render('convert/attest-presence.html.twig', [
            'planif' => $planif,
            'stagiaire' => $stagiaire,
            'refdossier' => $refdossier
        ]);
    }

    /**
     * @Route("/convert-convocation/{id}-{idSt}", name="convert.convocation", methods="GET|POST")
     */
    public function convocation(int $id, int $idSt)
    {
        $planif = $this->planifRepository->find($id);
        $stagiaire = $this->stagiaireRepository->find($idSt);

        $date = $planif->getDates()->first()->getDateAnnee() . $planif->getDates()->first()->getDateMois() . $planif->getDates()->first()->getDateJour();
        $refdossier = $date . $id;

        return $this->render('/convert/convocation.html.twig', [
            'planif' => $planif,
            'stagiaire' => $stagiaire,
            'refdossier' => $refdossier
        ]);
    }


    /**
     * @Route("/convert-enquete-chaud/{id}-{idSt}", name="convert.enquete-chaud", methods="GET|POST")
     */
    public function enqueteChaud(int $id, int $idSt)
    {
        $planif = $this->planifRepository->find($id);
        $stagiaire = $this->stagiaireRepository->find($idSt);

        $date = $planif->getDates()->first()->getDateAnnee() . $planif->getDates()->first()->getDateMois() . $planif->getDates()->first()->getDateJour();
        $refdossier = $date . $id;

        return $this->render('/convert/enquete-chaud.html.twig', [
            'planif' => $planif,
            'stagiaire' => $stagiaire,
            'refdossier' => $refdossier
        ]);
    }

    /**
     * @Route("/convert-enquete-froid/{id}-{idSt}", name="convert.enquete-froid", methods="GET|POST")
     */
    public function enqueteFroid(int $id, int $idSt)
    {
        $planif = $this->planifRepository->find($id);
        $stagiaire = $this->stagiaireRepository->find($idSt);

        $date = $planif->getDates()->first()->getDateAnnee() . $planif->getDates()->first()->getDateMois() . $planif->getDates()->first()->getDateJour();
        $refdossier = $date . $id;

        return $this->render('/convert/enquete-froid.html.twig', [
            'planif' => $planif,
            'stagiaire' => $stagiaire,
            'refdossier' => $refdossier
        ]);
    }

    /**
     * @Route("/convert-enquete-client/{id}", name="convert.enquete-client", methods="GET|POST")
     */
    public function enqueteClient(int $id)
    {
        $planif = $this->planifRepository->find($id);

        $date = $planif->getDates()->first()->getDateAnnee() . $planif->getDates()->first()->getDateMois() . $planif->getDates()->first()->getDateJour();
        $refdossier = $date . $id;

        return $this->render('/convert/enquete-client.html.twig', [
            'planif' => $planif,
            'refdossier' => $refdossier
        ]);
    }

    /**
     * @Route("/convert-depouillement/{id}", name="convert.depouillement", methods="GET|POST")
     * @param Planif $planif
     * @return Response
     */
    public function depouillement(Planif $planif)
    {
        $id = $planif->getId();
        $date = $planif->getDates()->first()->getDateAnnee() . $planif->getDates()->first()->getDateMois() . $planif->getDates()->first()->getDateJour();
        $refdossier = $date . $id;

        return $this->render('convert/depouillement.html.twig', [
            'planif' => $planif,
            'refdossier' => $refdossier
        ]);
    }

    /**
     * @Route("/convert-programme/{id}", name="convert.programme", methods="GET|POST")
     * @param Planif $planif
     * @return Response
     */
    public function programme(Planif $planif): Response
    {
        $id = $planif->getId();
        $date = $planif->getDates()->first()->getDateAnnee() . $planif->getDates()->first()->getDateMois() . $planif->getDates()->first()->getDateJour();
        $refdossier = $date . $id;

        return $this->render('convert/programme.html.twig', [
            'planif' => $planif,
            'refdossier' => $refdossier
        ]);
    }

    /**
     * @Route("/convert-plan-action/{id}", name="convert-planAction", methods="CONVERT")
     * @param PlanAction $planAction
     * @return Response
     */
    public function convertPlanAction(PlanAction $planAction): Response
    {

        $id = $planAction->getId();
        $planifId = $planAction->getPlanif()->getId();
        $nom = $planAction->getPlanif()->getProgramme()->getSlug();
        $of = $planAction->getPlanif()->getOrganisme()->getSlug();
        $organismeId = $planAction->getPlanif()->getOrganisme()->getId();
        $date = $planAction->getPlanif()->getDates()->first()->getDateAnnee() . $planAction->getPlanif()->getDates()->first()->getDateMois() . $planAction->getPlanif()->getDates()->first()->getDateJour();

        $plan = new Process([
            'wkhtmltopdf',
            '--footer-html', 'http://formabil.fr/convert-footer/' . $organismeId,
            '-T', '30px',
            '-L', '30px',
            '-B', '80px',
            '-R', '30px',
            'http://formabil.fr/convert-planAction/' . $id,
            'convert/' . $of . '/' . $date . $planifId . '/' . $date . $planifId . '-plan-action.pdf'
        ]);
        $plan->run();

        return $this->redirectToRoute('planif.finder', ['id' => $planifId]);
    }

    /**
     * @Route("/convert-planAction/{id}", name="convert.plan.action", methods="GET|POST")
     * @param PlanAction $planAction
     * @return Response
     */
    public function planAction(PlanAction $planAction): Response
    {
        $planif = $planAction->getPlanif();
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
        return $this->render('convert/plan-action.html.twig', [
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
            'planAction' => $planAction
        ]);
    }

    /**
     * @Route("/convert-programme-amont/{id}", name="convert.programme.amont", methods="GET|POST")
     * @param Formation $programme
     * @return Response
     */
    public function programmeAmont(Formation $programme): Response
    {
        return $this->render('convert/programme-amont.html.twig', [
            'programme' => $programme
        ]);
    }

    /**
     * @Route("/convert-inscription-client/{id}", name="convert.inscription.client", methods="GET|POST")
     * @param Formation $programme
     * @return Response
     */
    public function inscriptionClient(Formation $programme): Response
    {
        return $this->render('convert/inscription-client.html.twig', [
            'programme' => $programme
        ]);
    }

    /**
     * @Route("/convert-inscription-stagiaire/{id}", name="convert.inscription.stagiaire", methods="GET|POST")
     * @param Formation $programme
     * @return Response
     */
    public function inscriptionStagiaire(Formation $programme): Response
    {
        return $this->render('convert/inscription-stagiaire.html.twig', [
            'programme' => $programme
        ]);
    }

    /**
     * @Route("/convert-footer/{id}", name="convert.footer", methods="GET|POST")
     * @param Organisme $organisme
     * @return Response
     */
    public function footer(Organisme $organisme)
    {
        return $this->render('convert/footer.html.twig', [
            'organisme' => $organisme
        ]);
    }

}