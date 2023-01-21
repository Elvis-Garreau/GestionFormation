<?php


namespace App\Controller\admin;


use App\Entity\Formation;
use App\Entity\Prerequi;
use App\Form\PrerequiType;
use App\Repository\PrerequiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPrerequisController extends AbstractController
{

    /**
     * @var PrerequiRepository
     */
    private $prerequiRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(PrerequiRepository $prerequiRepository, EntityManagerInterface $entityManager)
    {
        $this->prerequiRepository = $prerequiRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/prerequis-admin/{id}", name="admin.prerequis.index", methods="GET|POST")
     * @param Formation $formation
     * @return Response
     */
    public function index(Formation $formation): Response
    {
        $prerequis = $this->prerequiRepository->findAllByFormation($formation);

        return $this->render('admin/prerequis/prerequis-gerer.html.twig', [
            'prerequis' => $prerequis,
            'formation' => $formation
        ]);
    }

    /**
     * @Route("/prerequi-admin/new-{id}", name="admin.prerequi.new")
     * @param Formation $formation
     * @param Request $request
     * @return Response
     */
    public function new(Formation $formation, Request $request): Response
    {
        $prerequi = new Prerequi();

        $form = $this->createForm(PrerequiType::class, $prerequi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $prerequi->setFormation($formation);
            $this->entityManager->persist($prerequi);
            $this->entityManager->flush();
            $this->addFlash('succes', 'le prerequis  a bien été créé');
            $formationId = $formation->getId();
            return $this->redirectToRoute('admin.prerequis.index', ['id' => $formationId]);
        }

        return $this->render('admin/prerequis/prerequi-new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/prerequi-admin/{id}", name="admin.prerequi.edit", methods="GET|POST")
     * @param Prerequi $prerequi
     * @param Request $request
     * @return Response
     */
    public function edit(Prerequi $prerequi, Request $request): Response
    {
        $form = $this->createForm(PrerequiType::class, $prerequi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('succes', 'Le prerequis a bien été mis à jour');
            $formation = $prerequi->getFormation()->getId();
            return $this->redirectToRoute('admin.prerequis.index', ['id' => $formation]);
        }

        return $this->render('admin/prerequis/prerequi-edit.html.twig', [
            'prerequi' => $prerequi,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/prerequi-admin/{id}", name="admin.prerequi.delete", methods="DELETE")
     * @param Prerequi $prerequi
     * @param Request $request
     * @return Response
     */
    public function delete(Prerequi $prerequi, Request $request): Response
    {
        if($this->isCsrfTokenValid('delete' . $prerequi->getId(), $request->get('_token'))){
            $this->entityManager->remove($prerequi);
            $this->entityManager->flush();
            $this->addFlash('succes', 'le prerequis a bien été supprimé');
        }
        $formation = $prerequi->getFormation()->getId();
        return $this->redirectToRoute('admin.prerequis.index', ['id' => $formation]);
    }

}