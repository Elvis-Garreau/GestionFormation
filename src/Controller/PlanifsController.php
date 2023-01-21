<?php


namespace App\Controller;


use App\Entity\Planif;
use App\Entity\PlanifSearch;
use App\Form\PlanifSearchType;
use App\Form\SearchClientType;
use App\Repository\PlanifRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlanifsController extends AbstractController
{

    /**
     * @var PlanifRepository
     */
    private $planifRepository;

    public function __construct(PlanifRepository $planifRepository)
    {
        $this->planifRepository = $planifRepository;
    }

    /**
     * @Route("/Planifications", name="planifs.index")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $form = $this->createForm(PlanifSearchType::class);
        $search = $form->handleRequest($request);

        $userOrganisme = $this->getUser()->getOrganisme()->getId();
        $organisme = $this->getUser()->getOrganisme();

        $planifs = $paginator->paginate(
            $this->planifRepository->findByOrganismeWithSearch($userOrganisme, $search),
            $request->query->getInt('page', 1),
            6
        );

        if ($form->isSubmitted() && $form->isValid()){
            $planifs = $paginator->paginate(
                $this->planifRepository->findByOrganismeWithSearch($userOrganisme, $search),
                $request->query->getInt('page', 1),
                6
            );
        }

        return $this->render('pages/planifs-passed.html.twig', [
            'planifs' => $planifs,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/planification/{id}", name="planif.show")
     * @param Planif $planif
     * @return Response
     */
    public function show(Planif $planif): Response
    {
        $id = $planif->getId();

        $isDate = $planif->getDates();
        if ($isDate->isEmpty()){
            $date = 'none';
        }else{
            $date = $planif->getDates()->first()->getDateAnnee() . $planif->getDates()->first()->getDateMois() . $planif->getDates()->first()->getDateJour();
        }
        $of = $planif->getOrganisme()->getSlug();

        $path = 'convert/' . $of . '/' . $date . $id;

        $filesystem = new Filesystem();

        $finder = new Finder();
        $files = '';
        if ($filesystem->exists($path))
        {
            $files = $finder->files()->in($path);
        };

        return $this->render('pages/planif.html.twig', [
            'planif' => $planif,
            'files' => $files
        ]);
    }

}