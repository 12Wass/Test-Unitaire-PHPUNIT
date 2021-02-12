<?php

namespace App\Controller;

use App\Entity\TodoList;
use App\Form\TodoListType;
use App\Repository\TodoListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

/**
 * @Route("/todo/list")
 */
class TodoListController extends AbstractController
{
    /**
     * @Route("/", name="todo_list_index", methods={"GET"})
     */
    public function index(TodoListRepository $todoListRepository): Response
    {
        return $this->render('todo_list/index.html.twig', [
            'todo_lists' => $todoListRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="todo_list_new", methods={"GET","POST"})
     */
    public function new(Request $request, SessionInterface $session): Response
    {

        if ($session->get('user')) {
            $user = $this->getDoctrine()->getManager()->getRepository(User::class)->find($session->get('user'));
        }

        if (isset($user) && $user->getTodoList() != null) {
            return $this->redirectToRoute('todo_list_index', [], 301);
        }
        $todoList = new TodoList();
        $form = $this->createForm(TodoListType::class, $todoList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && isset($user)) {
            $todoList->setUser($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($todoList);
            $entityManager->flush();
            return $this->redirectToRoute('todo_list_index', [], 201);
        } elseif (!isset($user)) {
            return $this->redirectToRoute('user_new');
        }

        return $this->render('todo_list/new.html.twig', [
            'todo_list' => $todoList,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="todo_list_show", methods={"GET"})
     */
    public function show(TodoList $todoList): Response
    {
        return $this->render('todo_list/show.html.twig', [
            'todo_list' => $todoList,
        ]);
    }

}
