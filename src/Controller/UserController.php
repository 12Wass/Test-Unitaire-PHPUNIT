<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, SessionInterface $session): Response
    {

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setBirthday('1998-10-05 17:45:54');
            if ($user->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $isExisted = $entityManager->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);
                $session->set('user', $user);
                if (!$isExisted) {
                    $entityManager->persist($user);
                    $entityManager->flush();
                    return new Response($this->render('element/accueil.html.twig'), 201, ['Content-Type' => 'text/html']);
                }
                return new Response("Il semblerait qu'un compte portant cet email existe Deja.", 409);

            } else {
                return new Response('Une erreur est survenue lors de la soumission du formulaire, l\' utilisateur semble incorrect', 422);
            }

        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public
    function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

}
