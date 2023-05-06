<?php

namespace App\Controller;

use App\Entity\Atelier;
use App\Entity\Evenements;
use App\Entity\Favoris;
use App\Entity\Hackatons;
use App\Entity\Inscription;
use App\Entity\Utilisateurs;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class APIController extends AbstractController
{
    #[Route('/a/p/i', name: 'app_a_p_i')]
    public function index(): Response
    {
        return $this->render('api/index.html.twig', [

            'controller_name' => 'APIController',
        ]);
    }

    #[Route('/api/hackathons', name: 'app_api_hackathon', methods: 'GET')]
    public function hackathon(ManagerRegistry $doctrine): JsonResponse
    {
        $hackatons = $doctrine->getRepository(Hackatons::class)->findAll();
        $tab = [];
        foreach ($hackatons as $unhack) {
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

    #[Route('/api/hackathons/{id}', name: 'app_api_unhackathon')]
    public function detail_hackathon(ManagerRegistry $doctrine, $id): JsonResponse
    {
        $unhack = $doctrine->getRepository(Hackatons::class)->findOneBy(['id' => $id]);
        $tab = [];
        $tab = [
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

    #[Route('/inscription/hackathon/{id}', name: 'app_api_inscription_hackathon')]
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
        $em =  $doctrine->getManager();

        // on persiste et on flush 
        $em->persist($inscription);
        $em->flush();
        //on fait une flash message
        //si ca a fonctionné :
        $this->addFlash('success', 'Vous êtes inscrit à ce hackathon');
        return $this->redirectToRoute('app_inscriptions');
    }

    #[Route('/desinscription/hackathon/{id}', name: 'app_api_desinscription_hackathon')]
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
        $em =  $doctrine->getManager();

        // on persiste et on flush 
        $em->remove($inscription);
        $em->flush();
        //on fait une flash message
        //si ca a fonctionné :
        $this->addFlash('success', 'Vous êtes désinscrit de ce hackathon');
        return $this->redirectToRoute('app_inscriptions');
    }


    #[Route('/api/utilisateurs', name: 'app_api_utilisateurs')]
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
    }

    #[Route('/api/evenements', name: 'app_api_evenements')]
    public function evenements(ManagerRegistry $doctrine): JsonResponse
    {
        $evenements = $doctrine->getRepository(Evenements::class)->findAll();
        $tab = [];

        foreach ($evenements as $unevenement) {
            $tab[] = [
                'id' => $unevenement->getId(),
                'libelle' => $unevenement->getLibelle(),
                'dateEvent' => $unevenement->getDateEvent(),
                'heure' => $unevenement->getHeure(),
                'duree' => $unevenement->getDuree(),
                'salle' => $unevenement->getSalle(),
                'type' =>
                //on retourne un type Atelier ou Conference en fonction de la classe fille ou se trouve l'évenement
                $unevenement instanceof Atelier ? 'atelier' : 'conference',
                'hackathon' => $unevenement->getHackathon()->getId(),

            ];
        }
        return new JsonResponse($tab);
    }
    #[Route('/api/evenements/hackathon/{id}', name: 'app_api_evenements_hack')]
    public function evenements_hack(ManagerRegistry $doctrine, $id): JsonResponse
    {
        $evenements = $doctrine->getRepository(Evenements::class)->findBy(['hackathon' => $id]);
        $tab = [];
        foreach ($evenements as $unevenement) {
            $tab[] = [
                'id' => $unevenement->getId(),
                'libelle' => $unevenement->getLibelle(),
                'dateEvent' => $unevenement->getDateEvent(),
                'heure' => $unevenement->getHeure(),
                'duree' => $unevenement->getDuree(),
                'salle' => $unevenement->getSalle(),
                'type' =>
                //on retourne un type Atelier ou Conference en fonction de la classe fille ou se trouve l'évenement
                $unevenement instanceof Atelier ? 'atelier' : 'conference',
                'hackathon' => $unevenement->getHackathon()->getId(),

            ];
        }
        return new JsonResponse($tab);
    }
    #[Route('/api/evenements/{id}', name: 'app_api_unevenement')]
    public function detail_evenement(ManagerRegistry $doctrine, $id): JsonResponse
    {
        $unevenement = $doctrine->getRepository(Evenements::class)->findOneBy(['id' => $id]);
        $tab = [];
        $tab = [
            'id' => $unevenement->getId(),
            'libelle' => $unevenement->getLibelle(),
            'dateEvent' => $unevenement->getDateEvent(),
            'heure' => $unevenement->getHeure(),
            'duree' => $unevenement->getDuree(),
            'salle' => $unevenement->getSalle(),
            'hackathon' => $unevenement->getHackathon()->getId(),
        ];
        return new JsonResponse($tab);
    }

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
