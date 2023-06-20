<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Search;
use App\Form\SearchType;
use App\Entity\MovieSerie;
use App\Form\MovieSerieType;
use App\Repository\UserRepository;
use App\Repository\MovieSerieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

/**
 * @Route("/movie/serie")
 */
class MovieSerieController extends AbstractController
{

    /**
     * @Route("/", name="movie_serie_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */

    public function index(MovieSerieRepository $movieSerieRepository): Response
    {
        $search = new Search();
        $formSearch = $this->createForm(SearchType::class,$search);


        return $this->render('movie_serie/index.html.twig', [
            'movie_series' => $movieSerieRepository->findAll(),
            'formSearch' => $formSearch->createView(), 
        ]);
    }


    /**
     * @Route("/new", name="movie_serie_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request, SluggerInterface $slugger): Response
    {
        $search = new Search();
        $formSearch = $this->createForm(SearchType::class,$search);


        $movieSerie = new MovieSerie();
        $form = $this->createForm(MovieSerieType::class, $movieSerie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
              /** @var UploadedFile $img_affiche */
            // On repure fichier renseigné dans le form
            $img_affiche = $form->get('imgAffiche')->getData();
            $img_header = $form->get('imgHeader')->getData();
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($img_affiche)
             {
                $originalFilename = pathinfo($img_affiche->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$img_affiche->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $img_affiche->move(
                        $this->getParameter('upload_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $movieSerie->setImgAffiche($newFilename);
            }

            if ($img_header)
            {
                $originalFilename = pathinfo($img_header->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$img_header->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $img_header->move(
                        $this->getParameter('upload_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $movieSerie->setImgHeader($newFilename);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($movieSerie);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('movie_serie/new.html.twig', [
            'movie_serie' => $movieSerie,
            'form' => $form->createView(),
            'formSearch' => $formSearch->createView(),

        ]);
    }

    /**
     * @Route("/{id}", name="movie_serie_show", methods={"GET"})
     */
    public function show(MovieSerie $movieSerie, MovieSerieRepository $movieId ): Response
    {
        $search = new Search();
        $formSearch = $this->createForm(SearchType::class,$search);

        if ($this->getUser() !== null){
            $user = $this->getUser();
            $userId = $user->getId();
            $favori = $user->getFavoris();
         } 
         else {
            $favori = [];
            $userId = null;
         }
        

        // $favori= $user->findOneBy(
        //     ['userId' => $userId],
        //     ['movieId' => $movieId->find($id)->getId()]
        // );


        return $this->render('movie_serie/show.html.twig', [
            'movie_serie' => $movieSerie,
            'formSearch' => $formSearch->createView(), 
            'userId' => $userId,
            'favori' => $favori,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="movie_serie_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, MovieSerie $movieSerie, SluggerInterface $slugger): Response
    {
        $search = new Search();
        $formSearch = $this->createForm(SearchType::class,$search);

        $form = $this->createForm(MovieSerieType::class, $movieSerie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



              /** @var UploadedFile $img_affiche */
            // On repure fichier renseigné dans le form
            $img_affiche = $form->get('imgAffiche')->getData();
            $img_header = $form->get('imgHeader')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($img_affiche)
             {
                $originalFilename = pathinfo($img_affiche->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$img_affiche->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $img_affiche->move(
                        $this->getParameter('upload_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $movieSerie->setImgAffiche($newFilename);
            }

            if ($img_header)
            {
                $originalFilename = pathinfo($img_header->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$img_header->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $img_header->move(
                        $this->getParameter('upload_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $movieSerie->setImgHeader($newFilename);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('movie_serie/edit.html.twig', [
            'movie_serie' => $movieSerie,
            'form' => $form->createView(),
            'formSearch' => $formSearch->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="movie_serie_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, MovieSerie $movieSerie): Response
    {

        if ($this->isCsrfTokenValid('delete'.$movieSerie->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($movieSerie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/search/filter", name="movie_serie_search")
     */
    public function search(Request $request, MovieSerieRepository $movieSerieRepository ): Response
    {
        $genreFilter = $request->query->get('genre');   
        $platformFilter = $request->query->get('platform');   
        $publishDateFilter = $request->query->get('pushblishDate');   
        $typeFilter = $request->query->get('type');   

        $result = $movieSerieRepository->searchFilter($genreFilter,$platformFilter,$publishDateFilter,$typeFilter);

        return new JsonResponse($result);
    }

    /**
     * @Route("/{id}/action/favori", name="movie_serie_favori", methods={"PUT"})
     *
     * @return void
     */
    public function setFavoris(Request $request, MovieSerie $movieSerie){
        $userId = $request->request->get('userId');
        $user  = $this->getDoctrine()->getRepository(User::class)->find($userId);

        if ($user === null){
            throw new BadRequestException('Utilisateur non existant');
        }

        $user->addFavori($movieSerie);

        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();   
                
        return new Response('OK');
    }

}

