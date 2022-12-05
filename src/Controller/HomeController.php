<?php

namespace App\Controller;

use App\Entity\Hackatons;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;


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
    public function home(ManagerRegistry $doctrine): Response
    {
        $hackatons = $doctrine->getRepository(Hackatons::class)->findAll();
        return $this->render('b_head.html.twig', [
            'hackathons' => $hackatons,
        ]);
    }
}
