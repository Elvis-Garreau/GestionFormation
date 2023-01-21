<?php


namespace App\Controller;


use App\Entity\Client;
use App\Form\SearchClientType;
use App\Repository\ClientRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientsController Extends AbstractController
{

    /**
     * @var ClientRepository
     */
    private $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * @Route("/Clients", name="clients.index")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $userOrganisme = $this->getUser()->getOrganisme()->getId();

        $clients = $paginator->paginate(
            $this->clientRepository->findByOrganisme($userOrganisme),
            $request->query->getInt('page', 1),
            6
        );

        $form = $this->createForm(SearchClientType::class);
        $search = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clients = $paginator->paginate(
                $this->clientRepository->search($userOrganisme, $search->get('mot')->getData()),
                $request->query->getInt('page', 1),
                6
            );
        }

        return $this->render('pages/clients.html.twig', [
            'clients' => $clients,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/client/{id}", name="client.show")
     * @param Client $client
     * @return Response
     */
    public function show(Client $client): Response
    {
        return $this->render('pages/client.html.twig', [
            'client' => $client
        ]);
    }

}