<?php

namespace App\Controller;
use App\Entity\User;

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

        var_dump($keyword);

        $em = $this->getDoctrine()->getEntityManager();
//        if ($request->isXmlHttpRequest()) {
            
            $artistes = $em->getRepository(User::class)->findBy(
                ['username' => $keyword]
            );

            $keyword = "%" . $keyword . "%";
            $results = $em->getRepository(User::class)->createQueryBuilder('u')
            ->where('u.username LIKE :keyword')
            ->orWhere('u.nom LIKE :keyword')
            ->setParameter('keyword', $keyword)
            ->getQuery()
            ->getResult();
            
            $data = array();
            
            if (count($results) > 0){
                foreach($results as $result){
                    $data[] = (object)["name" => $result->getNom(), "username" => $result->getUsername()];    
                }
                $json = ["data" => $data, "error" => false];
            }
            else{
                $json = ["data" => $data, "error" => true];
            }

            return  new JsonResponse($json);
//        }
        // else{
        //     // return $this->render('ajax/index.html.twig', [
        //     //     'controller_name' => 'AjaxController',
        //     // ]);
        // }
    }
   
    
}
