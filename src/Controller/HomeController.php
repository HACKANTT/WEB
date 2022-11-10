<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/HomeController.php',
        ]);
    }
    #[Route('/', name: 'app_home')]
    public function home(): JsonResponse
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'Bienvenue sur Fou de Séries',
        ]); 
    }
    #[Route('/bdd', name: 'app_bdd')]
    public function testEntity(ManagerRegistry $doctrine): Response
    {
        $serie = new Serie();
        $entityManager = $doctrine->getManager();
        // tell Doctrine you want to (eventually) save the serie (no queries yet)
        $entityManager->persist($serie);
        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        // return new Response('Saved new serie with id '.$serie->getId());
        return $this->render('home/testEntity.html.twig', 
        );
}
}
