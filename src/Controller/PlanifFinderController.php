<?php


namespace App\Controller;


use App\Entity\Planif;
use App\Form\UploadType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class PlanifFinderController extends AbstractController
{

    /**
     * @param Planif $planif
     * @return string
     */
    public function getPath(Planif $planif): string
    {
        $id = $planif->getId();
        $date = $planif->getDates()->first()->getDateAnnee() . $planif->getDates()->first()->getDateMois() . $planif->getDates()->first()->getDateJour();
        $of = $planif->getOrganisme()->getSlug();

        return 'convert/' . $of . '/' . $date . $id;
    }

    /**
     * @Route("/planif-finder/{id}", name="planif.finder", methods="GET|POST")
     * @param Planif $planif
     * @return Response
     */
    public function finderAll(Planif $planif): Response
    {
        $path = $this->getPath($planif);

        $files = new Finder();
        $files
            ->files()
            ->followLinks()
            ->in($path)
            ->sortByName()
        ;

        return $this->render('pages/planif-finder.html.twig', [
            'planif' => $planif,
            'files' => $files
        ]);
    }

    /**
     * @Route("/planif-finder-convention/{id}", name="planif.finder.convention", methods="GET|POST")
     * @param Planif $planif
     * @return Response
     */
    public function finderConvention(Planif $planif): Response
    {
        $path = $this->getPath($planif);

        $files = new Finder();
        $files
            ->files()
            ->followLinks()
            ->in($path)
            ->name('*-convention.pdf')
            ->sortByName()
        ;

        return $this->render('pages/planif-finder-convention.html.twig', [
            'planif' => $planif,
            'files' => $files
        ]);
    }

    /**
     * @Route("/planif-finder-attestation/{id}", name="planif.finder.attestation", methods="GET|POST")
     * @param Planif $planif
     * @return Response
     */
    public function finderAttestation(Planif $planif): Response
    {
        $path = $this->getPath($planif);

        $files = new Finder();
        $files
            ->files()
            ->followLinks()
            ->in($path)
            ->name('*-attestation-presence.pdf')
            ->sortByName()
        ;

        return $this->render('pages/planif-finder-attestation.html.twig', [
            'planif' => $planif,
            'files' => $files
        ]);
    }

    /**
     * @Route("/planif-finder-convocation/{id}", name="planif.finder.convocation", methods="GET|POST")
     * @param Planif $planif
     * @return Response
     */
    public function finderConvocation(Planif $planif): Response
    {
        $path = $this->getPath($planif);

        $files = new Finder();
        $files
            ->files()
            ->followLinks()
            ->in($path)
            ->name('*-convocation.pdf')
            ->sortByName()
        ;

        return $this->render('pages/planif-finder-convocation.html.twig', [
            'planif' => $planif,
            'files' => $files
        ]);
    }

    /**
     * @Route("/planif-finder-emargement/{id}", name="planif.finder.emargement", methods="GET|POST")
     * @param Planif $planif
     * @return Response
     */
    public function finderEmargement(Planif $planif): Response
    {
        $path = $this->getPath($planif);

        $files = new Finder();
        $files
            ->files()
            ->followLinks()
            ->in($path)
            ->name('*-emargement*')
            ->sortByName()
        ;

        return $this->render('pages/planif-finder-emargement.html.twig', [
            'planif' => $planif,
            'files' => $files
        ]);
    }

    /**
     * @Route("/planif-finder-programme/{id}", name="planif.finder.programme", methods="GET|POST")
     * @param Planif $planif
     * @return Response
     */
    public function finderProgramme(Planif $planif): Response
    {
        $path = $this->getPath($planif);

        $files = new Finder();
        $files
            ->files()
            ->followLinks()
            ->in($path)
            ->name('*-programme.pdf')
            ->sortByName()
        ;

        return $this->render('pages/planif-finder-programme.html.twig', [
            'planif' => $planif,
            'files' => $files
        ]);
    }

    /**
     * @Route("/planif-finder-enquete/{id}", name="planif.finder.enquete", methods="GET|POST")
     * @param Planif $planif
     * @return Response
     */
    public function finderEnquete(Planif $planif): Response
    {
        $path = $this->getPath($planif);

        $files = new Finder();
        $files
            ->files()
            ->followLinks()
            ->in($path)
            ->name('*-enquete*')
            ->sortByName()
        ;

        return $this->render('pages/planif-finder-enquete.html.twig', [
            'planif' => $planif,
            'files' => $files
        ]);
    }

    /**
     * @Route ("/download-files/{id}-{filename}", name="download.file", methods="GET|POST")
     * @param Planif $planif
     * @param $filename
     * @return Response
     */
    public function download(Planif $planif, $filename): Response
    {
        $path = $this->getPath($planif);
        return $this->file($path . '/' . $filename . '.pdf');
    }

    /**
     * @Route ("/show-files/{id}-{filename}", name="show.file", methods="GET|POST")
     * @param Planif $planif
     * @param $filename
     * @return Response
     */
    public function show(Planif $planif, $filename): Response
    {
        $path = $this->getPath($planif);
        return $this->file($path . '/' . $filename . '.pdf', null , ResponseHeaderBag::DISPOSITION_INLINE);
    }

    /**
     * @Route ("/replace-files/{id}-{filename}", name="replace.file", methods="GET|POST")
     * @param Planif $planif
     * @param $filename
     * @param Request $request
     * @return Response
     */
    public function replace(Planif $planif, $filename, Request $request): Response
    {
        $path = $this->getPath($planif);

        $form = $this->createForm(UploadType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $file = $form['attachement']->getData();
            $file->move($path, $filename . '.pdf');
            $this->addFlash('succes', 'le fichier ' . $filename . ' a bien été remplacé');
            $planifId = $planif->getId();
            return $this->redirectToRoute('planif.finder', ['id' => $planifId]);
        }

        return $this->render('pages/pdf-replace.html.twig', [
            'planif' => $planif,
            'path' => $path,
            'filename' => $filename,
            'form' => $form->createView()
        ]);
    }

}