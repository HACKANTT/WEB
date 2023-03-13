<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    //on fait une route qui inscrit un utilisateur à un hackathon
    #[Route('/inscription/{id}', name: 'app_inscription_hackathon')]
    //on fait une fonction qui va inscrire l'utilisateur
    public function inscription(Request $request, ManagerRegistry $doctrine): Response
    {
        //on fait une requete sql qui va inscrire l'utilisateur à un hackathon
        $query = $doctrine->createQuery(
            'UPDATE App\Entity\Utilisateurs u
            SET u.idHackathon = 1
            WHERE u.id = 1'
        );
        $query->execute();
        //on redirige vers le path app_home
        return $this->redirectToRoute('app_home');
    }    
}
