<?php

namespace App\Controller;

use App\Entity\Formateur;
use App\Repository\FormateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormateursController extends AbstractController
{

    /**
     * @var FormateurRepository
     */
    private $formateurRepository;

    public function __construct(FormateurRepository $formateurRepository)
    {
        $this->formateurRepository = $formateurRepository;
    }

    /**
     * @Route("/Formateurs", name="formateurs.index")
     * @return Response
     */
    public function index(): Response
    {
        $userOrganisme = $this->getUser()->getOrganisme()->getId();

        $formateurs = $this->formateurRepository->findByOrganisme($userOrganisme);

        return $this->render('pages/formateurs.html.twig', [
            'formateurs' => $formateurs
        ]);
    }

    /**
     * @Route ("/formateurs/{slug}-{id}", name="formateur.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Formateur $formateur
     * @param string $slug
     * @return Response
     */
    public function show(Formateur $formateur, string $slug): Response
    {
        if ($formateur->getSlug() !== $slug){
            return $this->redirectToRoute('formateur.show',[
                'id' => $formateur->getId(),
                'slug' => $formateur->getSlug()
            ], 301);
        }

        return $this->render('pages/formateur.html.twig', [
            'formateur' => $formateur
        ]);
    }

}