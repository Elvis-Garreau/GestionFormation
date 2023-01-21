<?php


namespace App\Controller\admin;


use App\Entity\Organisme;
use App\Entity\Veille;
use App\Form\VeilleType;
use App\Repository\VeilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminVeilleController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var VeilleRepository
     */
    private $veilleRepository;

    public function __construct(EntityManagerInterface $entityManager, VeilleRepository $veilleRepository)
    {
        $this->entityManager = $entityManager;
        $this->veilleRepository = $veilleRepository;
    }

    /**
     * @Route("/veilles", name="veilles.index")
     */
    public function index()
    {
        $userOrganisme = $this->getUser()->getOrganisme()->getId();

        $veilles = $this->veilleRepository->findByOrganisme($userOrganisme);

        return $this->render('pages/veilles.html.twig', [
            'veilles' => $veilles
        ]);
    }

    /**
     * @Route("/veille-admin/new-{id}", name="admin.veille.new")
     * @param Organisme $organisme
     * @param Request $request
     * @return Response
     */
    public function new(Organisme $organisme, Request $request): Response
    {
        $veille = new Veille();

        $form = $this->createForm(VeilleType::class, $veille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $veille->setOrganisme($organisme);
            $this->entityManager->persist($veille);
            $this->entityManager->flush();
            $this->addFlash('succes', 'La veille a bien été ajoutée');
            return $this->redirectToRoute('veilles.index');
        }

        return $this->render('admin/veilles/veille-new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("//veille-admin/edit-{id}", name="admin.veille.edit", methods="GET|POST")
     * @param Veille $veille
     * @param Request $request
     * @return Response
     */
    public function edit(Veille $veille, Request $request): Response
    {
        $form = $this->createForm(VeilleType::class, $veille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('succes', 'La veille a bien été mise à jour');
            return $this->redirectToRoute('veilles.index');
        }

        return $this->render('admin/veilles/veille-edit.html.twig', [
            'veille' => $veille,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/veille-admin/{id}", name="admin.veille.delete", methods="DELETE")
     * @param Veille $veille
     * @param Request $request
     * @return Response
     */
    public function delete(Veille $veille, Request $request): Response
    {
        if($this->isCsrfTokenValid('delete' . $veille->getId(), $request->get('_token'))){
            $this->entityManager->remove($veille);
            $this->entityManager->flush();
            $this->addFlash('succes', 'La veille a bien été supprimée');
        }
        return $this->redirectToRoute('veilles.index');
    }

}