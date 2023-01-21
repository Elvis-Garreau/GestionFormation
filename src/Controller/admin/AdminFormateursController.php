<?php


namespace App\Controller\admin;


use App\Entity\Formateur;
use App\Form\FormateurEditType;
use App\Form\FormateurType;
use App\Repository\FormateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminFormateursController extends AbstractController
{

    /**
     * @var FormateurRepository
     */
    private $formateurRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(FormateurRepository $formateurRepository, EntityManagerInterface $entityManager)
    {
        $this->formateurRepository = $formateurRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/formateur-admin", name="admin.formateurs.index")
     * @return Response
     */
    public function index(): Response
    {
        $userOrganisme = $this->getUser()->getOrganisme()->getId();

        $formateurs = $this->formateurRepository->findByOrganisme($userOrganisme);

        return $this->render('admin/formateurs/formateurs-gerer.html.twig', [
            'formateurs' => $formateurs
        ]);
    }

    /**
     * @Route("/formateur-admin/new", name="admin.formateur.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $formateur = new Formateur();

        $form = $this->createForm(FormateurType::class, $formateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $organisme = $this->getUser()->getOrganisme();
            $formateur->setOrganisme($organisme);
            $this->entityManager->persist($formateur);
            $this->entityManager->flush();
            $this->addFlash('succes', 'le formateur a bien été créé');
            return $this->redirectToRoute('admin.formateurs.index');
        }

        return $this->render('admin/formateurs/formateurs-new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/formateur-admin/{id}", name="admin.formateur.edit", methods="GET|POST")
     * @param Formateur $formateur
     * @param Request $request
     * @return Response
     */
    public function edit(Formateur $formateur, Request $request): Response
    {
        $form = $this->createForm(FormateurEditType::class, $formateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('succes', 'Le formateur a bien été mis à jour');
            return $this->redirectToRoute('admin.formateurs.index');
        }

        return $this->render('admin/formateurs/formateur-edit.html.twig', [
            'formateur' => $formateur,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/formateur-admin/{id}", name="admin.formateur.delete", methods="DELETE")
     * @param Formateur $formateur
     * @param Request $request
     * @return Response
     */
    public function delete(Formateur $formateur, Request $request): Response
    {
        if($this->isCsrfTokenValid('delete' . $formateur->getId(), $request->get('_token'))){
            $this->entityManager->remove($formateur);
            $this->entityManager->flush();
            $this->addFlash('succes', 'Le formateur a bien été supprimé');
        }
        return $this->redirectToRoute('admin.formateurs.index');
    }

}