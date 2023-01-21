<?php


namespace App\Controller;


use App\Entity\BiblDocu;
use App\Form\BiblDocuType;
use App\Repository\BiblDocuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BibliDocuController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var BiblDocuRepository
     */
    private $biblDocuRepository;

    public function __construct(EntityManagerInterface $entityManager, BiblDocuRepository $biblDocuRepository)
    {
        $this->entityManager = $entityManager;
        $this->biblDocuRepository = $biblDocuRepository;
    }

    /**
     * @Route("/bibliotheque-documentaire/new", name="bibli.docu.new")
     * @param Request $request
     * @return Response
     */
    public function newBibliDocu(Request $request): Response
    {
        $bibli = new BiblDocu();

        $form = $this->createForm(BiblDocuType::class, $bibli);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($bibli);
            $this->entityManager->flush();
            $this->addFlash('succes', 'La bibliothèque documentaire a bien été créée');
            return $this->redirectToRoute('home');
        }

        return $this->render('admin/bibliDocu/bibliDocu-new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/bibliotheque-documentaire", name="bibli.docu.show")
     */
    public function showBibliDocu()
    {
        $id = 12;
        $bibli = $this->biblDocuRepository->find($id);

        return $this->render('admin/bibliDocu/bibliDocu-show.html.twig', [
            'bibli' => $bibli
        ]);
    }

    public function editBibliocu()
    {

    }

}