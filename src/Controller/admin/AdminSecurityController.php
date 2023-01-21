<?php
namespace App\Controller\admin;

use App\Entity\User;
use App\Form\UserChooseOFType;
use App\Form\UserType;
use App\Form\UserUpdateForUserType;
use App\Form\UserUpdatePasswordType;
use App\Form\UserUpdateType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminSecurityController extends AbstractController
{

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * AdminSecurityController constructor.
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
    }

    /**
     * @Route("/user-admin", name="admin.user.index")
     * @return Response
     */
    public function index(): Response
    {
        $users = $this->userRepository->findAll();

        return $this->render('admin/users/users-gerer.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/user-admin/new", name="admin.user.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $this->encoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setUsername();
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $this->addFlash('succes', 'l\'utilisateur a bien été créé');
            return $this->redirectToRoute('admin.user.index');
        }

        return $this->render('admin/users/user-new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user-admin/{id}", name="admin.user.edit", methods="GET|POST")
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function updateAdmin(User $user, Request $request): Response
    {
        $form = $this->createForm(UserUpdateType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('succes', 'L\'utilisateur a bien été mis à jour');
            return $this->redirectToRoute('admin.user.index');
        }

        return $this->render('admin/users/user-edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user-utilisateur/{id}", name="utilisateur.user.edit", methods="GET|POST")
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function updateUser(User $user, Request $request): Response
    {
        $form = $this->createForm(UserUpdateForUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('succes', 'L\'utilisateur a bien été mis à jour');
            $userId = $this->getUser()->getId();
            return $this->redirectToRoute('user.show', ['id' => $userId]);
        }

        return $this->render('admin/users/user-utilisateur-edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user-admin-changePW/{id}", name="admin.user.change.password", methods="GET|POST")
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function updatePassword(User $user, Request $request): Response
    {
        $form = $this->createForm(UserUpdatePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $this->encoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $this->entityManager->flush();
            $this->addFlash('succes', 'l\'utilisateur a bien été modifié');
            return $this->redirectToRoute('admin.user.index');
        }

        return $this->render('admin/users/user-change-password.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user-admin-choose-OF/{id}", name="admin.user.choose.of", methods="GET|POST")
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function chooseOf(User $user, Request $request): Response
    {
        $form = $this->createForm(UserChooseOFType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('admin/users/user-choose-of.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user-admin/{id}", name="admin.user.delete", methods="DELETE")
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function delete(User $user, Request $request): Response
    {
        if($this->isCsrfTokenValid('delete' . $user->getId(), $request->get('_token'))){
            $this->entityManager->remove($user);
            $this->entityManager->flush();
            $this->addFlash('succes', 'l\'utilisateur a bien été supprimé');
        }
        return $this->redirectToRoute('admin.user.index');
    }

}