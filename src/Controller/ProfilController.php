<?php

namespace App\Controller;

use App\Entity\Favoris;
use App\Entity\Hackatons;
use App\Entity\Inscription;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(ManagerRegistry $doctrine): Response
    {
        //on retourne les informations de l'utilisateur connecté
        $user=$this->getUser();
        dump($user);
        return $this->render('profil/profil.html.twig', [
            'user' => $user,
        ]);
    }
    #[Route('/favoris', name: 'app_favoris')]
    public function favoris(ManagerRegistry $doctrine): Response
    {
        //retourne les hackathons favoris de l'utilisateur
        $favoris=$doctrine->getRepository(Favoris::class)
        ->findBy(['id_U' => $this->getUser()]);
        $hackathonsfavoris=$doctrine->getRepository(Hackatons::class)->findBy(['id' => $favoris]);
        return $this->render('profil/favoris.html.twig', [
            'hackathons' => $hackathonsfavoris,
            
        ]);
    }
    #[Route('/inscriptions', name: 'app_inscriptions')]
    public function inscriptions(ManagerRegistry $doctrine): Response
    {
        //retourne les hackathons auxquels l'utilisateur est inscrit
        $inscriptions=$doctrine->getRepository(Inscription::class)->findBy(['id_U' => $this->getUser()]);
        $hackathonsinscrits=$doctrine->getRepository(Hackatons::class)->findBy(['id' => $inscriptions]);
        //retourne les hackathons favoris de l'utilisateur
        $favoris=$doctrine->getRepository(Favoris::class)
        ->findBy(['id_U' => $this->getUser()]);
        $hackathonsfavoris=$doctrine->getRepository(Hackatons::class)->findBy(['id' => $favoris]);
        return $this->render('profil/inscriptions.html.twig', [
            'hackathons' => $hackathonsinscrits,
            'favoris' => $hackathonsfavoris
            
        ]);
    }
}
