<?php

namespace App\Controller;

use App\Controller\Mailer\MailerController;
use App\Entity\Formation;
use App\Entity\MailAmont;
use App\Entity\Planif;
use App\Form\MailAmontType;
use App\Form\SearchClientType;
use App\Form\UploadType;
use App\Repository\FormationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Process\Process;
use Symfony\Component\Routing\Annotation\Route;

class FormationsController extends AbstractController
{

    /**
     * @var FormationRepository
     */
    private $formationRepository;

    public function __construct(FormationRepository $formationRepository)
    {
        $this->formationRepository = $formationRepository;
    }


    /**
     * @param Formation $formation
     * @return string
     */
    public function getPath(Formation $formation): string
    {
        $id = $formation->getId();
        $of = $formation->getOrganisme()->getSlug();
        $nom = $formation->getSlug();

        return 'convert/' . $of . '/' . $nom . $id;
    }

    /**
     * @Route("/Formations", name="formations.index")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $userOrganisme = $this->getUser()->getOrganisme()->getId();

        $formations = $paginator->paginate(
            $this->formationRepository->findByOrganisme($userOrganisme),
            $request->query->getInt('page', 1),
            6
        );

        $form = $this->createForm(SearchClientType::class);
        $search = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formations = $paginator->paginate(
                $this->formationRepository->search($userOrganisme, $search->get('mot')->getData()),
                $request->query->getInt('page', 1),
                6
            );
        }

        return $this->render('pages/formations.html.twig', [
            'formations' => $formations,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/formations/{slug}-{id}", name="formation.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Formation $formation
     * @param string $slug
     * @param Request $request
     * @param MailerController $mail
     * @return Response
     */
    public function show(Formation $formation, string $slug, Request $request, MailerController $mail): Response
    {
        if ($formation->getSlug() !== $slug){
            return $this->redirectToRoute('formation.show',[
                'id' => $formation->getId(),
                'slug' => $formation->getSlug()
            ], 301);
        }

        $id = $formation->getId();
        $nom = $formation->getSlug();
        $of = $formation->getOrganisme()->getSlug();

        $mkdirOf = new Process(['mkdir', 'convert/' . $of]);
        $mkdirOf->run();

        $mkdirFormation = new Process(['mkdir', 'convert/' . $of . '/' . $nom . $id]);
        $mkdirFormation->run();

        $path = $this->getPath($formation);

        $files = new Finder();
        $files
            ->files()
            ->followLinks()
            ->in($path)
            ->sortByName()
        ;

        $contact = new MailAmont();
        $contact->setProgramme($formation);
        $form = $this->createForm(MailAmontType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mail->sendProgrammeAmont($contact);
            $this->addFlash('succes', 'Le mail a bien été envoyé');
            return $this->redirectToRoute('formation.show',[
                'id' => $formation->getId(),
                'slug' => $formation->getSlug()
            ]);
        }

        return $this->render('pages/formation.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
            'files' => $files
        ]);
    }

    /**
     * @Route ("/download-files-programme/{id}-{filename}", name="download.file.programme", methods="GET|POST")
     * @param Formation $formation
     * @param $filename
     * @return Response
     */
    public function download(Formation $formation, $filename): Response
    {
        $path = $this->getPath($formation);
        return $this->file($path . '/' . $filename . '.pdf');
    }

    /**
     * @Route ("/show-files-programme/{id}-{filename}", name="show.file.programme", methods="GET|POST")
     * @param Formation $formation
     * @param $filename
     * @return Response
     */
    public function showFile(Formation $formation, $filename): Response
    {
        $path = $this->getPath($formation);
        return $this->file($path . '/' . $filename . '.pdf', null , ResponseHeaderBag::DISPOSITION_INLINE);
    }

}