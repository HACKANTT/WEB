<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use App\Form\UtilisateursType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function addUtilisateur(Request $request, ManagerRegistry $doctrine): Response
    {
        $utilisateur= new Utilisateurs();
        $form=$this->createForm(UtilisateursType::class,$utilisateur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            // password_hash()
            $em=$doctrine->getManager();
            $em->persist($utilisateur);
            $em->flush();
            return $this->redirectToRoute('app_home');
        }
        
        return $this->render('inscription/inscription.html.twig', [
            'form' => $form->createView() 
        ]);
    }
}
