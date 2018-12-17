<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Evenement;
use App\Entity\Formation;
use App\Entity\Lieu;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class AjaxController extends AbstractController
{
    
    /**
     * @Route("/ajax", name="ajax")
     */
    public function index()
    {
        $request = Request::createFromGlobals();
        $keyword = $request->query->get("keyword");
        $em = $this->getDoctrine()->getEntityManager();
                
        if ($request->isXmlHttpRequest()) {
            // Test quel élément est ciblé
            $cible = (!empty($_GET['cible'])) ? strtolower($_GET['cible']) : null;
            if (!isset($cible)) {
                die('Aucun élément ciblé');
            }
            
            // Variable pour stocker les données lues en BDD
            $data = array();
            
            // Clé de recherche
            $keyword = "%" . $keyword . "%";
            
            // Recherche données sur les évènements
            if ($cible == "evenement")
            {   $data = $this->searchData($keyword, $em->getRepository(Evenement::class), $cible);
            }
                    
            // Recherche données sur les formations
            if ($cible == "formation")
            {   $data += $this->searchData($keyword, $em->getRepository(Formation::class), $cible);
            }
                    
            // Recherche données sur les lieux
            if ($cible == "lieu")
            {   $data += $this->searchData($keyword, $em->getRepository(Lieu::class), $cible);
            }
                    
            // Recherche données sur les artistes
            if ($cible == "artiste")
            {   $data += $this->searchData($keyword, $em->getRepository(User::class), $cible);
            }
                    
            // Pas d'erreur si des données sont dispos
            $error = true;
            if (!empty($data)) 
            $error = false;         
            // Réponse json en fonction de data et error
            $json = ["data" => $data, "error" => $error];
            return  new JsonResponse($json);
        }

        else{
            return $this->redirectToRoute('evenement_index'); // Retour sur la liste des evenements
        }
    }
        
    /**
     * Fonction de recherche de nom et id pour evenement, formation ou lieu
     */
    public function searchData($keyword, $repository, $cible): ?array {
        // Variable pour stocker les données lues en BDD
        $data = array();
    
        // Lecture en BDD
        if ($cible == "artiste"){
            $results = $repository->createQueryBuilder('a')
            ->where('a.username LIKE :keyword')
            ->orWhere('a.nom LIKE :keyword')
            ->setParameter('keyword', $keyword)
            ->getQuery()
            ->getResult();                
        }
        else {
            $results = $repository->createQueryBuilder('o')
                ->where('o.nom LIKE :keyword')
                ->setParameter('keyword', $keyword)
                ->getQuery()
                ->getResult();
        }
    
        // S'il y a des résultats
        if (count($results) > 0){
            // Stockage résultats dans data
            $nom = array();
            $id = array();
            $username = array();
            $nomArtiste = array();
            foreach($results as $result){
                if ($cible == "artiste"){
                    $type = $result->getType();
                    if (in_array("user_artiste", $type)) {
                        $nom[] = $result->getNom();
                        $prenom[] = $result->getPrenom();    
                        $username[] = $result->getUsername();    
                        $nomArtiste[] = $result->getNomArtiste();
                    }
                }
                else{
                    $nom[] = $result->getNom();
                    $id[] = $result->getId();
                }  
            }
            if ($cible == "artiste"){
                if (!empty($nom)) {
                    $data = [$cible => ["nom" => $nom, "prenom" => $prenom, "username" => $username, "nomartiste" => $nomArtiste]];
                }
            }
            else {
                $data = [$cible => ["nom" => $nom, "id" => $id]];
            }
        }
    
        return $data;
    }
        
}
