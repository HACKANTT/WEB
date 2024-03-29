<?php

namespace App\Controller;

use App\Entity\Favoris;
use App\Entity\Hackatons;
use App\Entity\Inscription;
use Doctrine\ORM\Mapping\Id;
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
    #[Route('/profil/favoris', name: 'app_favoris')]
    public function favoris(ManagerRegistry $doctrine): Response
    {
        //retourne les hackathons favoris de l'utilisateur
        $favoris=$doctrine->getRepository(Favoris::class)
        ->findBy(['id_U' => $this->getUser()]);
        dump($favoris);
        return $this->render('profil/favoris.html.twig', [
            'favoris' => $favoris,
        ]);
    }
    #[Route('/profil/inscriptions', name: 'app_inscriptions')]
    public function inscriptions(ManagerRegistry $doctrine): Response
    {
        //retourne les hackathons favoris de l'utilisateur
        $inscriptions=$doctrine->getRepository(Inscription::class)
        ->findBy(['id_U' => $this->getUser()]);
        $favorisId=$doctrine->getRepository(Favoris::class)
        ->findBy(['id_U' => $this->getUser()]);
        $favoris=[];
        foreach ($favorisId as $favori) {
            $favoris[]=$doctrine->getRepository(Hackatons::class)
            ->find($favori->getIdH());
        }
        return $this->render('profil/inscriptions.html.twig', [
            'hackathons' => $inscriptions,
            'favoris' => $favoris,
        ]);
    }
}
