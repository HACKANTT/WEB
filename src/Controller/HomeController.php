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
    #[Route('/', name: 'app_home')]
    public function home(ManagerRegistry $doctrine): Response
    {
        $hackathons = $doctrine->getRepository(Hackatons::class)->findAll();
        return $this->render('home/home.html.twig', [
            'hackathons' => $hackathons,
        ]);
    }
}
