<?php

namespace App\Controller;

use App\Entity\Atelier;
use App\Entity\Conference;
use App\Entity\Evenements;
use App\Entity\Favoris;
use App\Entity\Hackatons;
use App\Entity\Inscription;
use App\Entity\Utilisateurs;
use App\Entity\Inscrits;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class APIController extends AbstractController
{
    /*#[Route('/a/p/i', name: 'app_a_p_i')]
    public function index(): Response
    {
        return $this->render('api/index.html.twig', [

            'controller_name' => 'APIController',
        ]);
    }*/

    #[Route('/api/hackathons', name: 'app_api_hackathon', methods: 'GET')]
    public function hackathon(ManagerRegistry $doctrine): JsonResponse
    {
        $hackatons = $doctrine->getRepository(Hackatons::class)->findAll();
        $tab = [];
        foreach ($hackatons as $unhack) {
            $tab[] = [
                'id' => $unhack->getId(),
                'dateDebut' => 
                substr($unhack->getDateDebut()->format('d-m-Y H:i:s'), 0, 10),
                'dateFin' =>
                substr($unhack->getDateFin()->format('d-m-Y H:i:s'), 0, 10),
                'description' => $unhack->getDescription(),
                'image' => $unhack->getImage(),
                'nbPlaces' => $unhack->getNbPlaces(),
                'theme' => $unhack->getTheme(),
                'lieu' => $unhack->getLieu(),
                'rue' => $unhack->getRue(),
                'ville' => $unhack->getVille(),
                'cp' => $unhack->getCp(),
                'dateLimite' => $unhack->getDateLimite(),
                'heureDebut' => 
                substr($unhack->getHeureDebut()->format('d-m-Y H:i:s'), 11, 8),
                'heureFin' => 
                substr($unhack->getHeureFin()->format('d-m-Y H:i:s'), 11, 8),
            ];
        }
        return new JsonResponse($tab);
        
    }

    #[Route('/api/hackathons/{id}', name: 'app_api_unhackathon')]
    public function detail_hackathon(ManagerRegistry $doctrine, $id): JsonResponse
    {

        $unhack = $doctrine->getRepository(Hackatons::class)->findOneBy(['id' => $id]);
        //si le hackathon n,'existe pas on retourne une erreur
        if (!$unhack) {
            return new JsonResponse(['error' => 'Hackathon non trouvé'], 404);
        }
        $tab = [];
        $tab = [
            'id' => $unhack->getId(),
            'dateDebut' => 
            substr($unhack->getDateDebut()->format('d-m-Y H:i:s'), 0, 10),
            'dateFin' =>
            substr($unhack->getDateFin()->format('d-m-Y H:i:s'), 0, 10),
            'description' => $unhack->getDescription(),
            'image' => $unhack->getImage(),
            'nbPlaces' => $unhack->getNbPlaces(),
            'theme' => $unhack->getTheme(),
            'lieu' => $unhack->getLieu(),
            'rue' => $unhack->getRue(),
            'ville' => $unhack->getVille(),
            'cp' => $unhack->getCp(),
            'dateLimite' => $unhack->getDateLimite(),
            'heureDebut' => $unhack->getHeureDebut(),
            'heureFin' => $unhack->getHeureFin(),
        ];
        return new JsonResponse($tab);
    }

    #[Route('/fav/hackathon/{id}', name: 'app_api_fav_hackathon')]
    public function fav_hackathon($id, ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Hackatons::class);
        $leHackathon = $repository->find($id);
        $user = $this->getUser();
        $favoris = //$user->getFavoris();
        $doctrine->getRepository(Favoris::class)->findBy([
            'id_U' => $user,
        ]);//si l'utilisateur n'est pas connecté, on retourne une erreur
        if (!$user) {
            return $this->json(['error' => 'Vous devez être connecté pour ajouter un hackathon à vos favoris'], 403);
        }
        //si il existe un favori qui a le même idH et idU que ceux-la, on supprime cette ligne
        foreach ($favoris as $favori) {
            if ($favori->getIdH() == $leHackathon && $favori->getIdU() == $user) {
                $doctrine->getManager()->remove($favori);
                $doctrine->getManager()->flush();
                return $this->json(['success' => '0'], 200);
            }
        }
        //si l'utilisateur est connecté, on ajoute le hackathon à ses favoris
        dump($leHackathon);
        dump($user);
        $favoris = new Favoris();
        $favoris->setIdH($leHackathon);
        $favoris->setIdU($user);
        $doctrine->getManager()->persist($favoris);
        $doctrine->getManager()->flush();
        return $this->json(['success' => '1'], 200);
    }

    /*#[Route('/inscription/hackathon/{id}', name: 'app_api_inscription_hackathon')]
    public function inscription_hackathon($id, ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Hackatons::class);
        $leHackathon = $repository->find($id);
        try {
            //on vérifie si le hackathon existe
            if (!$leHackathon) {
                throw new \Exception('Hackathon non trouvé');
            }
            //on récupère l'utilisateur connecté
            $user = $this->getUser();
            //on vérifie si l'utilisateur est connecté
            if (!$user) {
                $this->addFlash('danger', 'Vous devez être connecté pour vous inscrire à un hackathon');
                return $this->redirectToRoute('app_login');
            }
            //on vérifie si l'utilisateur est déjà inscrit au hackathon
            if (
                $doctrine->getRepository(Inscription::class)->findOneBy([
                    'id_U' => $user,
                    'id_H' => $leHackathon,
                ]) != null
            ) {
                $this->addFlash('danger', 'Vous êtes déjà inscrit à ce hackathon');
                return $this->redirectToRoute('app_home');
            }
            //on crée une nouvelle inscription
            $inscription = new Inscription();
            //on associe l'utilisateur et le hackathon à l'inscription
            $inscription->setIdU($user);
            $inscription->setidH($leHackathon);
            $inscription->setDateInscription(new \DateTime());
        } catch (\Exception $e) {
            $this->addFlash('danger', $e->getMessage());
            return $this->redirectToRoute('app_home');
        }

        // on récupère le manager de doctrine 
        /** @var EntityManagerInterface */
        /*$em =  $doctrine->getManager();

        // on persiste et on flush 
        $em->persist($inscription);
        $em->flush();
        //on fait une flash message
        //si ca a fonctionné :
        $this->addFlash('success', 'Vous êtes inscrit à ce hackathon');
        return $this->redirectToRoute('app_inscriptions');
    }*/

    /*#[Route('/desinscription/hackathon/{id}', name: 'app_api_desinscription_hackathon')]
    public function desinscription_hackathon($id, ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Hackatons::class);
        $leHackathon = $repository->find($id);
        try {
            //on vérifie si le hackathon existe
            if (!$leHackathon) {
                throw new \Exception('Hackathon non trouvé');
            }
            //on récupère l'utilisateur connecté
            $user = $this->getUser();
            //on vérifie si l'utilisateur est connecté
            if (!$user) {
                $this->addFlash('danger', 'Vous devez être connecté pour vous désinscrire d\'un hackathon');
                return $this->redirectToRoute('app_login');
            }
            //on vérifie si l'utilisateur est déjà inscrit au hackathon
            if (
                $doctrine->getRepository(Inscription::class)->findOneBy([
                    'id_U' => $user,
                    'id_H' => $leHackathon,
                ]) == null
            ) {
                $this->addFlash('danger', 'Vous n\'êtes pas inscrit à ce hackathon');
                return $this->redirectToRoute('app_home');
            }
            //on crée une nouvelle inscription
            $inscription = new Inscription();
            //on associe l'utilisateur et le hackathon à l'inscription
            $inscription->setIdU($user);
            $inscription->setidH($leHackathon);
            $inscription->setDateInscription(new \DateTime());
        } catch (\Exception $e) {
            $this->addFlash('danger', $e->getMessage());
            return $this->redirectToRoute('app_home');
        }

        // on récupère le manager de doctrine 
        /** @var EntityManagerInterface */
        /*$em =  $doctrine->getManager();

        // on persiste et on flush 
        $em->remove($inscription);
        $em->flush();
        //on fait une flash message
        //si ca a fonctionné :
        $this->addFlash('success', 'Vous êtes désinscrit de ce hackathon');
        return $this->redirectToRoute('app_inscriptions');
    }*/


    /*#[Route('/api/utilisateurs', name: 'app_api_utilisateurs')]
    public function utilisateurs(ManagerRegistry $doctrine): JsonResponse
    {
        $utilisateurs = $doctrine->getRepository(Utilisateurs::class)->findAll();
        $tab = [];
        foreach ($utilisateurs as $unutilisateur) {
            $tab[] = [
                'id' => $unutilisateur->getId(),
                'nom' => $unutilisateur->getNom(),
                'prenom' => $unutilisateur->getPrenom(),
                'email' => $unutilisateur->getEmail(),
                'password' => $unutilisateur->getPassword(),
                'role' => $unutilisateur->getRole(),
                'dateNaissance' => $unutilisateur->getDateNaissance(),
                'telephone' => $unutilisateur->getTelephone(),
                'adresse' => $unutilisateur->getAdresse(),
                'codePostal' => $unutilisateur->getCodePostal(),
                'ville' => $unutilisateur->getVille(),
                'pays' => $unutilisateur->getPays(),
                'photo' => $unutilisateur->getPhoto(),
                'description' => $unutilisateur->getDescription(),
                'dateInscription' => $unutilisateur->getDateInscription(),
                'dateDerniereConnexion' => $unutilisateur->getDateDerniereConnexion(),
                'dateDerniereModification' => $unutilisateur->getDateDerniereModification(),
                'dateSuppression' => $unutilisateur->getDateSuppression(),
                'supprime' => $unutilisateur->getSupprime(),
            ];
        }
        return new JsonResponse($tab);
    }
    #[Route('/api/utilisateurs/{id}', name: 'app_api_unutilisateur')]
    public function detail_utilisateur(ManagerRegistry $doctrine, $id): JsonResponse
    {
        $unutilisateur = $doctrine->getRepository(Utilisateurs::class)->findOneBy(['id' => $id]);
        $tab = [];
        $tab = [
            'id' => $unutilisateur->getId(),
            'nom' => $unutilisateur->getNom(),
            'prenom' => $unutilisateur->getPrenom(),
            'email' => $unutilisateur->getEmail(),
            'password' => $unutilisateur->getPassword(),
            'role' => $unutilisateur->getRole(),
            'dateNaissance' => $unutilisateur->getDateNaissance(),
            'telephone' => $unutilisateur->getTelephone(),
            'adresse' => $unutilisateur->getAdresse(),
            'codePostal' => $unutilisateur->getCodePostal(),
            'ville' => $unutilisateur->getVille(),
            'pays' => $unutilisateur->getPays(),
            'photo' => $unutilisateur->getPhoto(),
            'description' => $unutilisateur->getDescription(),
            'dateInscription' => $unutilisateur->getDateInscription(),
            'dateDerniereConnexion' => $unutilisateur->getDateDerniereConnexion(),
            'dateDerniereModification' => $unutilisateur->getDateDerniereModification(),
            'dateSuppression' => $unutilisateur->getDateSuppression(),
            'supprime' => $unutilisateur->getSupprime(),
        ];
        return new JsonResponse($tab);
    }*/

    //on créé une route qui recoit en json les infos nom, prenom et mail d'une appli mobile et atelier pour créer un inscrit dans la tables Inscrits
    #[Route('/api/inscription/atelier', name: 'app_api_inscription_atelier', methods: ['POST'])]
    public function inscrits(Request $request,ManagerRegistry $doctrine): JsonResponse {
        $inscrits = $doctrine->getRepository(Inscrits::class)->findAll();
        //on récupère le contenu de la requete
        $content = $request->getContent();
        //si le contenu n'est pas vide
        if (!empty($content)) {
            //on décode le json en tableau associatif
            $inscrit = json_decode($content, true);
            //on récupère le nom, prenom et mail
            $nom = $inscrit['nom'];
            $prenom = $inscrit['prenom'];
            $mail = $inscrit['email'];
            //on récupère l'atelier
            $atelier = $doctrine->getRepository(Atelier::class)->findOneBy(['id' => $inscrit['atelier']]);
            //on vérifie qu'il n'y a pas déjà d'inscrit avec cet atelier et ce mail
            foreach ($inscrits as $uninscrit) {
                if ($uninscrit->getRelationAtelier() == $atelier && $uninscrit->getEmail() == $mail) {
                    return new JsonResponse(['error' => 'Vous êtes déjà inscrit à cet atelier'], 403);
                }
            }
            //on verifie qu'il reste de la place
            if ($atelier->getNbPlaces() <= count($atelier->getInscrits())) {
                return new JsonResponse(['error' => 'Il n\'y a plus de place pour cet atelier'], 403);
            }
            //on verifie que la date ne dépasse aps celle d'aujourd'hui 
            if ($atelier->getDateEvent() < new \DateTime()) {
                return new JsonResponse(['error' => 'La date de l\'atelier est dépassée'], 403);
            }
            //si tout est bon, on crée un nouvel inscrit
            $nouvelinscrit = new Inscrits();
            //on lui associe l'atelier
            $nouvelinscrit->setRelationAtelier($atelier);
            //on lui associe le nom, prenom et mail
            $nouvelinscrit->setNom($nom);
            $nouvelinscrit->setPrenom($prenom);
            $nouvelinscrit->setEmail($mail);
            //on persiste et on flush
            $doctrine->getManager()->persist($nouvelinscrit);
            $doctrine->getManager()->flush();
            //on retourne un message de succès
            return new JsonResponse(['success' => 'Inscription réussie'], 200);
            }
            //si le contenu est vide, on retourne une erreur
            return new JsonResponse(['error' => 'Aucun contenu'], 403);
        }


    /*#[Route('/api/evenements', name: 'app_api_evenements')]
    public function evenements(ManagerRegistry $doctrine): JsonResponse
    {
        $evenements = $doctrine->getRepository(Evenements::class)->findAll();
        $tab = [];
        foreach ($evenements as $unevenement) {
            if ($unevenement instanceof Atelier) {
                
            $tab[] = [
                'id' => $unevenement->getId(),
                'libelle' => $unevenement->getLibelle(),
                'dateEvent' =>
                //on ne prend que les caracteres YYYY-MM-DD
                substr($unevenement->getDateEvent()->format('d-m-Y H:i:s'), 0, 10),
                'heure' => 
                //on ne prend que les caracteres HH:MM:SS
                substr($unevenement->getHeure()->format('Y-m-d H:i:s'), 11, 8),
                'duree' =>
                //on ne prend que les caracteres HH:MM:SS
                substr($unevenement->getDuree()->format('Y-m-d H:i:s'), 11, 8),
                'salle' => $unevenement->getSalle(),
                'type' => 'atelier',
                'hackathon' => $unevenement->getHackathon()->getId(),
                'nbPlaces' => $unevenement->getNbPlaces(),
                'nbInscrits' => count($unevenement->getInscrits()),
                'inscrits' => $unevenement->getInscrits(),
            ];
        }
        if ($unevenement instanceof Conference) {
            $tab[] = [
                'id' => $unevenement->getId(),
                'libelle' => $unevenement->getLibelle(),
                'dateEvent' =>
                //on ne prend que les caracteres YYYY-MM-DD
                substr($unevenement->getDateEvent()->format('d-m-Y H:i:s'), 0, 10),
                'heure' => 
                //on ne prend que les caracteres HH:MM:SS
                substr($unevenement->getHeure()->format('Y-m-d H:i:s'), 11, 8),
                'duree' =>
                //on ne prend que les caracteres HH:MM:SS
                substr($unevenement->getDuree()->format('Y-m-d H:i:s'), 11, 8),
                'salle' => $unevenement->getSalle(),
                'type' => 'conference',
                'hackathon' => $unevenement->getHackathon()->getId(),
                'theme' => $unevenement->getTheme(),
                'intervenant' => $unevenement->getIntervenant(),
            ];
        }
        //si ce n'est aucun des deux, on retourne une erreur
        if (!$unevenement instanceof Conference && !$unevenement instanceof Atelier) {
            return new JsonResponse(['error' => 'Evenement non trouvé'], 404);
        }
    }
    return new JsonResponse($tab);
    }*/
    #[Route('/api/evenements/hackathon/{id}', name: 'app_api_evenements_hack')]
    public function evenements_hack(ManagerRegistry $doctrine, $id): JsonResponse
    {
        $evenements = $doctrine->getRepository(Evenements::class)->findBy(['hackathon' => $id]);
        $tab = [];
        foreach ($evenements as $unevenement) {
            if ($unevenement instanceof Atelier) {
                
            $tab[] = [
                'id' => $unevenement->getId(),
                'libelle' => $unevenement->getLibelle(),
                'dateEvent' =>
                //on ne prend que les caracteres YYYY-MM-DD
                substr($unevenement->getDateEvent()->format('d-m-Y H:i:s'), 0, 10),
                'heure' => 
                //on ne prend que les caracteres HH:MM:SS
                substr($unevenement->getHeure()->format('Y-m-d H:i:s'), 11, 8),
                'duree' =>
                //on ne prend que les caracteres HH:MM:SS
                substr($unevenement->getDuree()->format('Y-m-d H:i:s'), 11, 8),
                'salle' => $unevenement->getSalle(),
                'type' => 'atelier',
                'hackathon' => $unevenement->getHackathon()->getId(),
                'nbPlaces' => $unevenement->getNbPlaces(),
                'nbInscrits' => count($unevenement->getInscrits()),
                'inscrits' => $unevenement->getInscrits(),
            ];
        }
        if ($unevenement instanceof Conference) {
            $tab[] = [
                'id' => $unevenement->getId(),
                'libelle' => $unevenement->getLibelle(),
                'dateEvent' =>
                //on ne prend que les caracteres YYYY-MM-DD
                substr($unevenement->getDateEvent()->format('d-m-Y H:i:s'), 0, 10),
                'heure' => 
                //on ne prend que les caracteres HH:MM:SS
                substr($unevenement->getHeure()->format('Y-m-d H:i:s'), 11, 8),
                'duree' =>
                //on ne prend que les caracteres HH:MM:SS
                substr($unevenement->getDuree()->format('Y-m-d H:i:s'), 11, 8),
                'salle' => $unevenement->getSalle(),
                'type' => 'conference',
                'hackathon' => $unevenement->getHackathon()->getId(),
                'theme' => $unevenement->getTheme(),
                'intervenant' => $unevenement->getIntervenant(),
            ];
        }
        //si ce n'est aucun des deux, on retourne une erreur
        if (!$unevenement instanceof Conference && !$unevenement instanceof Atelier) {
            return new JsonResponse(['error' => 'Evenement non trouvé'], 404);
        }
    }
        return new JsonResponse($tab);
    }
    /*#[Route('/api/evenement/{id}', name: 'app_api_unevenement')]
    public function detail_evenement(ManagerRegistry $doctrine, $id): JsonResponse
    {
        $unevenement = $doctrine->getRepository(Evenements::class)->findOneBy(['id' => $id]);
        $unconfatelier = $doctrine->getRepository($unevenement instanceof Atelier ? Atelier::class : Conference::class)->findOneBy(['id' => $id]);
        $tab = [];
        //si c'est un atelier
        if ($unevenement instanceof Atelier) {
            $tab = [
                'id' => $unconfatelier->getId(),
                'libelle' =>$unconfatelier->getLibelle(),
                'dateEvent' =>
                //on ne prend que les caracteres YYYY-MM-DD
                substr($unconfatelier->getDateEvent()->format('d-m-Y H:i:s'), 0, 10),
                'heure' =>
                //on ne prend que les caracteres HH:MM:SS
                substr($unconfatelier->getHeure()->format('Y-m-d H:i:s'), 11, 8),
                'duree' =>
                //on ne prend que les caracteres HH:MM:SS
                substr($unconfatelier->getDuree()->format('Y-m-d H:i:s'), 11, 8),
                'salle' => $unconfatelier->getSalle(),
                'hackathon' => $unconfatelier->getHackathon()->getId(),
                'type' => 'atelier',
                'nbPlaces' => $unevenement->getNbPlaces(),
                'nbInscrits' => count($unevenement->getInscrits()),
                'inscrits' => $unconfatelier->getInscrits(),
            ];
        }
        //si c'est une conference
        if ($unevenement instanceof Conference) {
            $tab = [
                'id' => $unconfatelier->getId(),
                'libelle' =>$unconfatelier->getLibelle(),
                'dateEvent' =>
                //on ne prend que les caracteres YYYY-MM-DD
                substr($unconfatelier->getDateEvent()->format('d-m-Y H:i:s'), 0, 10),
                'heure' =>
                //on ne prend que les caracteres HH:MM:SS
                substr($unconfatelier->getHeure()->format('Y-m-d H:i:s'), 11, 8),
                'duree' =>
                //on ne prend que les caracteres HH:MM:SS
                substr($unconfatelier->getDuree()->format('Y-m-d H:i:s'), 11, 8),
                'salle' => $unconfatelier->getSalle(),
                'hackathon' => $unconfatelier->getHackathon()->getId(),
                'type' => 'conference',
                'theme' => $unconfatelier->getTheme(),
                'intervenant' => $unconfatelier->getIntervenant(),
            ];
        }

        /*$tab = [
            'id' => $unevenement->getId(),
            'libelle' => $unevenement->getLibelle(),
            'dateEvent' =>
            //on ne prend que les caracteres YYYY-MM-DD
            substr($unevenement->getDateEvent()->format('d-m-Y H:i:s'), 0, 10),
            'heure' => 
            //on ne prend que les caracteres HH:MM:SS
            substr($unevenement->getHeure()->format('Y-m-d H:i:s'), 11, 8),
            'duree' =>
            //on ne prend que les caracteres HH:MM:SS
            substr($unevenement->getDuree()->format('Y-m-d H:i:s'), 11, 8),
            'salle' => $unevenement->getSalle(),
            'hackathon' => $unevenement->getHackathon()->getId(),
            'type' =>
            //on retourne un type Atelier ou Conference en fonction de la classe fille ou se trouve l'évenement
            $unevenement instanceof Atelier ? 'atelier' : 'conference',
            //on retourne aussi toutes les propriétés de la conference ou de l'atelier en question
            //si c'est une conference
            $unevenement instanceof Conference ? 'conference' : 'atelier' => [
                'id' => $confatelier->getId(),
                'theme' => $confatelier->getTheme(),
                'intervenant' => $confatelier->getIntervenant(),
            ],
            //si c'est un atelier
            $unevenement instanceof Atelier ? 'atelier' : 'conference' => [
                'nbParticipants' => $confatelier->getNbParticipants(),
                'inscrits' => $confatelier->getInscrits(),

           ]
            
        ];*/
        /*return new JsonResponse($tab);
    }*/

    ##############################RECHERCHE##############################

    /*#[Route('/api/recherche/{str}', name:'app_api_recherche')]
    public function recherche(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $recherche = $request->query->get('{str}');
        $hackathons = $doctrine->getRepository(Hackatons::class)->findBy(['ville' => $recherche]);
        $tab = [];
        foreach ($hackathons as $unhack) {
            $tab[] = [
                'id' => $unhack->getId(),
                'dateDebut' => $unhack->getDateDebut(),
                'dateFin' => $unhack->getDateFin(),
                'description' => $unhack->getDescription(),
                'image' => $unhack->getImage(),
                'nbPlaces' => $unhack->getNbPlaces(),
                'theme' => $unhack->getTheme(),
                'lieu' => $unhack->getLieu(),
                'rue' => $unhack->getRue(),
                'ville' => $unhack->getVille(),
                'cp' => $unhack->getCp(),
                'dateLimite' => $unhack->getDateLimite(),
                'heureDebut' => $unhack->getHeureDebut(),
                'heureFin' => $unhack->getHeureFin(),
            ];
        }
        return new JsonResponse($tab);
    }
    */

    ##############################SERIES (exemple à ne pas suppr)##############################


    /*
    #[Route('/api/series/{id}', name: 'app_api_series_id', methods: ['GET'])]
    public function getUneSerie(PdoFouDeSerie $pdoFouDeSerie, $id): Response
    {
        $uneSerie = $pdoFouDeSerie->getUneSerie($id);
        if ($uneSerie) {
            dump($uneSerie);
            $TabSerie = [
                'id' => $uneSerie['id'],
                'titre' => $uneSerie['titre'],
                'resume' => $uneSerie['resume'],
                'duree' => $uneSerie['duree']

            ];
            return new JsonResponse($TabSerie);
        } else {
            return new JsonResponse(['message' => 'Serie inexistante'], 404);
        }
    }

    #[Route('/api/series', name: 'app_api_newSerie', methods: ['POST'])]
    public function newSerie(Request $request, PdoFouDeSerie $pdoFouDeSerie)
    {
        $content = $request->getContent();
        if (!empty($content)) {
            $laserie = json_decode($content, true);
            $laSerieAjouter = $pdoFouDeSerie->setLaSerie($laserie);
            $tabJson =
                [
                    'id' => $laSerieAjouter['id'],
                    'titre' => $laSerieAjouter['titre'],
                    'resume' => $laSerieAjouter['resume'],
                    'duree' => $laSerieAjouter['duree'],
                    'premiereDiffusion' => $laSerieAjouter['premiereDiffusion'],
                ];
        }
        return new JsonResponse($tabJson, Response::HTTP_CREATED);
    }

    #[Route('/api/series/{id}', name: 'app_api_series_delete', methods: ['DELETE'])]
    public function deleteUneSerie(PdoFouDeSerie $pdoFouDeSerie, $id): Response
    {
        if (isset($id)) {
            $pdoFouDeSerie->deleteSerie($id);
            if ($pdoFouDeSerie) {
                return new JsonResponse(['message' => 'Serie supprimée'], 200);
            } else {
                return new JsonResponse(['message' => 'Serie inexistante'], 404);
            }
        } else {
            return new JsonResponse(['message' => 'Serie non supprime'], 404);
        }
    }

    #[Route('/api/series/{id}', name: 'app_api_updateSerie', methods: ['PUT'])]
    public function updateSerieComplete(Request $request, PdoFouDeSerie $pdoFouDeSerie, $id)
    {
        $laserie = $pdoFouDeSerie->getLesSeries($id);
        if ($laserie == false) {
            return new JsonResponse(['message' => 'Serie inexistante'], response::HTTP_NOT_FOUND);
        }
        $content = $request->getContent();
        if (!empty($content)) {
            $laserie = json_decode($content, true);
            $laSeriemodif = $pdoFouDeSerie->updateSerieComplete($id, $laserie);
            $tabJson =
                [
                    'id' => $laSeriemodif['id'],
                    'titre' => $laSeriemodif['titre'],
                    'resume' => $laSeriemodif['resume'],
                    'duree' => $laSeriemodif['duree'],
                    'premiereDiffusion' => $laSeriemodif['premiereDiffusion'],
                ];
        }
        return new JsonResponse($tabJson, Response::HTTP_OK);
    }
    
*/
}
