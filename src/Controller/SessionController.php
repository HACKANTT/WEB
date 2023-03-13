<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use App\Form\UtilisateursType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SessionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function addUtilisateur(AuthenticationUtils $authenticationUtils, Request $request, ManagerRegistry $doctrine): Response
    {
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $utilisateur= new Utilisateurs();
        $form=$this->createForm(UtilisateursType::class,$utilisateur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $utilisateur->setPassword(password_hash($utilisateur->getPassword(),PASSWORD_BCRYPT));
            $em=$doctrine->getManager();
            $em->persist($utilisateur);
            $em->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('session/inscription.html.twig', [
            'form' => $form->createView(),
            'last_username' => $lastUsername,
        ]);
    }

    #[Route('/connexion', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
         // get the login error if there is one
         $error = $authenticationUtils->getLastAuthenticationError();

         // last username entered by the user
         $lastUsername = $authenticationUtils->getLastUsername();

         //si il y a une erreur on fait une flash_error "danger"
            if ($error){
                $this->addFlash('danger','Identifiants incorrects');
            }

         //on redirige vers le path app_home
        return $this->redirectToRoute('app_home',[
             'last_username' => $lastUsername,
             'error' => $error,
             ]
    );
    }

    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout()
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

    #[Route('/forgot-pwd', name:'app_forgot_pwd')]
    public function forgotPwd(): Response
    {
        return $this->render('session/forgot-pwd.html.twig', [
            'controller_name' => 'SessionController',
        ]);
    }
}
