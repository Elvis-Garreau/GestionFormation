<?php


namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{

    /**
     * @Route ("/user/{id}", name="user.show")
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response
    {
        return $this->render('pages/user.html.twig', [
            'user' => $user
        ]);
    }

}