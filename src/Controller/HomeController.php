<?php

namespace App\Controller;


use App\Entity\Search;
use App\Form\SearchType;
use App\Entity\MovieSerie;
use App\Twig\AppExtension;
use App\Form\MovieSerieType;
use App\Repository\GenreRepository;
use App\Repository\MovieSerieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * 
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(MovieSerieRepository $movieSerieRepository, GenreRepository $genreRepository): Response
    {
        
        
        $search = new Search();
        $formSearch = $this->createForm(SearchType::class,$search);

        // Array permettant d'afficher les années
        // du filtre date de sortie
        $array = [];

        for ($i = 1990; $i <= 2021; $i++){
            array_push($array, $i);
        };

        $random_movie_serie = $movieSerieRepository->findAll();
        // cette fonction permet d'afficher
        // de facon aléatoire les donées 
        shuffle($random_movie_serie);
       
        return $this->render('home/index.html.twig', [
            'controller_name'   => 'HomeController',
            'formSearch'        => $formSearch->createView(), 
            'movie_series'      => $random_movie_serie,
            'genres'            => $genreRepository->findAll(),
            'years'             => $array,

        ]);
    }

    
    /**
     * @Route("/fiche", name="fiche")
     */
    public function fiche(): Response
    {
        return $this->render('home/fiche.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     *@Route("/search", name="search")
    */
    public function search(Request $request, MovieSerieRepository $movieSerieRepository): Response
    {
        $search = new Search();
        $formSearch= $this->createForm(SearchType::class,$search);
        $formSearch->handleRequest($request);
     
        
        $movies= [];

        if($formSearch->isSubmitted() && $formSearch->isValid()) {
            //on récupère le nom d'article tapé dans le formulaire
            $title = $search->getTitles();
            if ($title != "") {
                   $movies= $movieSerieRepository->search($title);
            } else {
                    $movies= $this->getDoctrine()->getRepository(MovieSerie::class)->findAll();
                    //si si aucun titles n'est fourni on affiche tous les movies
            }
        
            return $this->render('home/search.html.twig',[ 
                'formSearch' => $formSearch->createView(), 
                'movies' => $movies
                ]
            ); 
        };


        return $this->render('home/index.html.twig',[ 
                'formSearch' => $formSearch->createView(), 
                'movies' => $movies
            ]
         ); 
            
    }





}
