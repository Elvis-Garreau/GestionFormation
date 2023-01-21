<?php


namespace App\Controller\admin;

use App\Entity\Organisme;
use App\Entity\RepresentantOf;
use App\Form\RepresentantOfType;
use App\Repository\RepresentantOfRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminRepresentantOfController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var RepresentantOfRepository
     */
    private $representantOfRepository;

    public function __construct(RepresentantOfRepository $representantOfRepository, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->representantOfRepository = $representantOfRepository;
    }

    /**
     * @Route("/representants-admin/{id}", name="admin.representants.index", methods="GET|POST")
     * @param Organisme $organisme
     * @return Response
     */
    public function index(Organisme $organisme): Response
    {
        $representants = $this->representantOfRepository->findByOrganisme($organisme);

        return $this->render('admin/representants/representants-gerer.html.twig', [
            'representants' => $representants,
            'organisme' => $organisme
        ]);
    }

    /**
     * @Route("/representant-admin/new-{id}", name="admin.representant.new")
     * @param Organisme $organisme
     * @param Request $request
     * @return Response
     */
    public function new(Organisme $organisme, Request $request): Response
    {
        $representant = new RepresentantOf();

        $form = $this->createForm(RepresentantOfType::class, $representant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $representant->setOrganisme($organisme);
            $this->entityManager->persist($representant);
            $this->entityManager->flush();
            $this->addFlash('succes', 'le représentant a bien été créé');
            $organismeId = $organisme->getId();
            return $this->redirectToRoute('admin.representants.index', ['id' => $organismeId]);
        }

        return $this->render('admin/representants/representant-new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/representant-admin/{id}", name="admin.representant.edit", methods="GET|POST")
     * @param RepresentantOf $representant
     * @param Request $request
     * @return Response
     */
    public function edit(RepresentantOf $representant, Request $request): Response
    {
        $form = $this->createForm(RepresentantOfType::class, $representant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('succes', 'Le representant a bien été mis à jour');
            $organismeId = $representant->getOrganisme()->getId();
            return $this->redirectToRoute('admin.representants.index', ['id' => $organismeId]);
        }

        return $this->render('admin/representants/representant-edit.html.twig', [
            'representant' => $representant,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/representant-admin/{id}", name="admin.representant.delete", methods="DELETE")
     * @param RepresentantOf $representant
     * @param Request $request
     * @return Response
     */
    public function delete(RepresentantOf $representant, Request $request): Response
    {
        if($this->isCsrfTokenValid('delete' . $representant->getId(), $request->get('_token'))){
            $this->entityManager->remove($representant);
            $this->entityManager->flush();
            $this->addFlash('succes', 'le représentant a bien été supprimé');
        }
        $organismeId = $representant->getOrganisme()->getId();
        return $this->redirectToRoute('admin.representants.index', ['id' => $organismeId]);
    }

}