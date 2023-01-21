<?php


namespace App\Controller\admin;


use App\Entity\Formation;
use App\Entity\ModuleFormation;
use App\Form\ModuleFormationType;
use App\Repository\ModuleFormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminModulesController Extends AbstractController
{

    /**
     * @var ModuleFormationRepository
     */
    private $moduleFormationRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(ModuleFormationRepository $moduleFormationRepository, EntityManagerInterface $entityManager)
    {
        $this->moduleFormationRepository = $moduleFormationRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/modules-admin/{id}", name="admin.modules.index", methods="GET|POST")
     * @param Formation $formation
     * @return Response
     */
    public function index(Formation $formation): Response
    {
        $modules = $this->moduleFormationRepository->findAllByFormation($formation);

        return $this->render('admin/modules/modules-gerer.html.twig', [
            'modules' => $modules,
            'formation' => $formation
        ]);
    }

    /**
     * @Route("/module-admin/new-{id}", name="admin.module.new")
     * @param Formation $formation
     * @param Request $request
     * @return Response
     */
    public function new(Formation $formation, Request $request): Response
    {
        $module = new ModuleFormation();

        $form = $this->createForm(ModuleFormationType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $module->setFormation($formation);
            $this->entityManager->persist($module);
            $this->entityManager->flush();
            $this->addFlash('succes', 'le module a bien été créé');
            $formationId = $formation->getId();
            return $this->redirectToRoute('admin.modules.index', ['id' => $formationId]);
        }

        return $this->render('admin/modules/module-new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/module-admin/{id}", name="admin.module.edit", methods="GET|POST")
     * @param ModuleFormation $module
     * @param Request $request
     * @return Response
     */
    public function edit(ModuleFormation $module, Request $request): Response
    {
        $form = $this->createForm(ModuleFormationType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('succes', 'Le module a bien été mis à jour');
            $formation = $module->getFormation()->getId();
            return $this->redirectToRoute('admin.modules.index', ['id' => $formation]);
        }

        return $this->render('admin/modules/module-edit.html.twig', [
            'module' => $module,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/module-admin/{id}", name="admin.module.delete", methods="DELETE")
     * @param ModuleFormation $module
     * @param Request $request
     * @return Response
     */
    public function delete(ModuleFormation $module, Request $request): Response
    {
        if($this->isCsrfTokenValid('delete' . $module->getId(), $request->get('_token'))){
            $this->entityManager->remove($module);
            $this->entityManager->flush();
            $this->addFlash('succes', 'l\'objectif a bien été supprimé');
        }
        $formation = $module->getFormation()->getId();
        return $this->redirectToRoute('admin.modules.index', ['id' => $formation]);
    }

}