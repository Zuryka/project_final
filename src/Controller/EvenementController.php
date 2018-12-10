<?php

namespace App\Controller;

use App\Entity\Evenement;

//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;





/**
 * @Route("/evenement", name="evenement_")
 */
class EvenementController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('evenement/index.html.twig', [
            'controller_name' => 'EvenementController',
        ]);
    }

    /**
     * @Route("/show/{id}", name="show", requirements={"id" = "\d+"})
     */
    public function show($id)//Evenement $entity)
    {

        $em = $this->getDoctrine()->getManager();
        // Récupére l'article correpondant à $id
        $entity = $em->find($id);

        return $this->render('evenement/show.html.twig', array(
            'entity' => $entity,
        ));
    }
}
