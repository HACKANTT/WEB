<?php

namespace App\Controller;

use App\Entity\Evenements;
use App\Entity\Hackatons;
use App\Entity\Utilisateurs;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

#[Route('/hackathon', name: 'app_api_hackathon', methods:'GET')]
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

#[Route('/hackathon/{id}', name: 'app_api_unhackathon')]
public function detail_hackathon(ManagerRegistry $doctrine, $id): JsonResponse
{
    $unhack = $doctrine->getRepository(Hackatons::class)->findOneBy(['id' =>$id]);
    $tab = [];
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
        return new JsonResponse($tab);
    }
#[Route('/utilisateurs', name: 'app_api_utilisateurs')]
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
#[Route('/utilisateurs/{id}', name: 'app_api_unutilisateur')]
public function detail_utilisateur(ManagerRegistry $doctrine, $id): JsonResponse
{
    $unutilisateur = $doctrine->getRepository(Utilisateurs::class)->findOneBy(['id' =>$id]);
    $tab = [];
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
        return new JsonResponse($tab);
    }

#[Route('/evenements', name:'app_api_evenements')]
public function evenements(ManagerRegistry $doctrine): JsonResponse
{
    $evenements = $doctrine->getRepository(Evenements::class)->findAll();
    $tab = [];
    foreach ($evenements as $unevenement) {
        $tab[] = [
            'id' => $unevenement->getId(),
            'dateDebut' => $unevenement->getDateDebut(),
            'dateFin' => $unevenement->getDateFin(),
            'description' => $unevenement->getDescription(),
            'image' => $unevenement->getImage(),
            'nbPlaces' => $unevenement->getNbPlaces(),
            'theme' => $unevenement->getTheme(),
            'lieu' => $unevenement->getLieu(),
            'rue' => $unevenement->getRue(),
            'ville' => $unevenement->getVille(),
            'cp' => $unevenement->getCp(),
            'dateLimite' => $unevenement->getDateLimite(),
            'heureDebut' => $unevenement->getHeureDebut(),
            'heureFin' => $unevenement->getHeureFin(),
        ];
    }
    return new JsonResponse($tab);
}
#[Route('/evenements/{id}', name: 'app_api_unevenement')]
public function detail_evenement(ManagerRegistry $doctrine, $id): JsonResponse
{
    $unevenement = $doctrine->getRepository(Evenements::class)->findOneBy(['id' =>$id]);
    $tab = [];
        $tab[] = [
            'id' => $unevenement->getId(),
            'dateDebut' => $unevenement->getDateDebut(),
            'dateFin' => $unevenement->getDateFin(),
            'description' => $unevenement->getDescription(),
            'image' => $unevenement->getImage(),
            'nbPlaces' => $unevenement->getNbPlaces(),
            'theme' => $unevenement->getTheme(),
            'lieu' => $unevenement->getLieu(),
            'rue' => $unevenement->getRue(),
            'ville' => $unevenement->getVille(),
            'cp' => $unevenement->getCp(),
            'dateLimite' => $unevenement->getDateLimite(),
            'heureDebut' => $unevenement->getHeureDebut(),
            'heureFin' => $unevenement->getHeureFin(),
        ];
        return new JsonResponse($tab);
    }




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
