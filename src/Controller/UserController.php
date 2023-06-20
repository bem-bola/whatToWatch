<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Search;
use App\Form\UserType;
use App\Form\SearchType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/user")
 * @IsGranted("ROLE_USER")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        $search = new Search();
        $formSearch = $this->createForm(SearchType::class,$search);
        
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'formSearch' => $formSearch->createView(), 
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $search = new Search();
        $formSearch = $this->createForm(SearchType::class,$search);

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'formSearch' => $formSearch->createView(), 
        ]);
    }

    /**
     * @Route("/profile", name="user_show", methods={"GET"})
     */
    public function show(): Response
    {
        $search = new Search();
        $formSearch = $this->createForm(SearchType::class,$search);

        $user = $this->getUser();
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'formSearch' => $formSearch->createView(), 
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $search = new Search();
        $formSearch = $this->createForm(SearchType::class,$search);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'formSearch' => $formSearch->createView(), 
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}