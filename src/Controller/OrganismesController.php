<?php

namespace App\Controller;

use App\Entity\Organisme;
use App\Repository\OrganismeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrganismesController extends AbstractController
{

    /**
     * @var OrganismeRepository
     */
    private $organismeRepository;

    public function __construct(OrganismeRepository $organismeRepository)
    {
        $this->organismeRepository = $organismeRepository;
    }

    /**
     * @Route("/organismes", name="organismes.index")
     * @return Response
     */
    public function index(): Response
    {
        $organismes = $this->organismeRepository->findAll();

        return $this->render('pages/organismes.html.twig', [
            'organismes' => $organismes
        ]);
    }

    /**
     * @Route ("/mon-organisme/{slug}-{id}", name="organisme.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Organisme $organisme
     * @param string $slug
     * @return Response
     */
    public function show(Organisme $organisme, string $slug): Response
    {
        if ($organisme->getSlug() !== $slug){
            return $this->redirectToRoute('organisme.show',[
                'id' => $organisme->getId(),
                'slug' => $organisme->getSlug()
            ], 301);
        }

        return $this->render('pages/organisme.html.twig', [
            'organisme' => $organisme
        ]);
    }

}