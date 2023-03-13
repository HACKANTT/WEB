<?php

namespace App\Controller;

use App\Entity\Hackatons;
use App\Entity\Inscription;
use App\Entity\Utilisateurs;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class InscriptionController extends AbstractController
{
    //on fait une route qui inscrit un utilisateur à un hackathon
    #[Route('/inscription/{id}', name: 'app_inscription_hackathon')]
    //on fait une fonction qui va inscrire l'utilisateur
    public function inscription(Request $request, ManagerRegistry $doctrine, $id): Response
{
    //on récupère le hackathon correspondant
    $hackathon = $doctrine->getRepository(Hackatons::class)->find($id);
    //on vérifie si le hackathon existe
    if (!$hackathon) {
        throw $this->createNotFoundException('Hackathon introuvable');
    }
    //on récupère l'utilisateur connecté
    $user = $this->getUser();
    //on vérifie si l'utilisateur est connecté
    if (!$user) {
        return $this->redirectToRoute('app_login');
    }
    $test=$doctrine->getRepository(Inscription::class)->findOneBy([
        'id_U' => $user,
        'id_H' => $hackathon,
    ]);
    //on vérifie si l'utilisateur est déjà inscrit au hackathon
    if (
        $doctrine->getRepository(Inscription::class)->findOneBy([
            'id_U' => $user,
            'id_H' => $hackathon,
        ])!=null) 
        {
            return $this->redirectToRoute('app_home');
        }
    //on crée une nouvelle inscription
    $inscription = new Inscription();
    //on associe l'utilisateur et le hackathon à l'inscription
    $inscription->setIdU($user);
    $inscription->setidH($hackathon);
    $inscription->setDateInscription(new \DateTime());
    
    
     // on récupère le manager de doctrine 
     /** @var EntityManagerInterface */
     $em =  $doctrine ->getManager();
     
     // on persiste et on flush 
     $em ->persist($inscription);
     $em ->flush();
        //on fait une flash message
        //si ca a fonctionné :
        $this->addFlash('success', 'Vous êtes inscrit à ce hackathon');
        //sinon :
        $this->addFlash('danger', 'Vous n\'êtes pas inscrit à ce hackathon');
        return $this->redirectToRoute('app_home');
    }
}
