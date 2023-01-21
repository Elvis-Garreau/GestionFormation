<?php


namespace App\Controller\admin;


use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminClientsController extends AbstractController
{

    /**
     * @var ClientRepository
     */
    private $clientRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(ClientRepository $clientRepository, EntityManagerInterface $entityManager)
    {
        $this->clientRepository = $clientRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/clients-admin", name="admin.clients.index")
     * @return Response
     */
    public function index(): Response
    {
        $userOrganisme = $this->getUser()->getOrganisme()->getId();

        $clients = $this->clientRepository->findByOrganisme($userOrganisme);

        return $this->render('admin/clients/clients-gerer.html.twig', [
            'clients' => $clients
        ]);
    }

    /**
     * @Route("/client-admin/new", name="admin.client.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $client = new Client();

        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $organisme = $this->getUser()->getOrganisme();
            $client->setOrganisme($organisme);
            $this->entityManager->persist($client);
            $this->entityManager->flush();
            $this->addFlash('succes', 'le client a bien été créé');
            return $this->redirectToRoute('admin.clients.index');
        }

        return $this->render('admin/clients/client-new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/client-admin/{id}", name="admin.client.edit", methods="GET|POST")
     * @param Client $client
     * @param Request $request
     * @return Response
     */
    public function edit(Client $client, Request $request): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('succes', 'Le client a bien été mis à jour');
            return $this->redirectToRoute('admin.clients.index');
        }

        return $this->render('admin/clients/client-edit.html.twig', [
            'client' => $client,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/client-admin/{id}", name="admin.client.delete", methods="DELETE")
     * @param Client $client
     * @param Request $request
     * @return Response
     */
    public function delete(Client $client, Request $request): Response
    {
        if($this->isCsrfTokenValid('delete' . $client->getId(), $request->get('_token'))){
            $this->entityManager->remove($client);
            $this->entityManager->flush();
            $this->addFlash('succes', 'le client a bien été supprimé');
        }
        return $this->redirectToRoute('admin.clients.index');
    }

}