<?php

namespace App\Controller;
use App\Entity\Evenement;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/evenement", name="evenement_")
 */
class EvenementController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(Evenement::class)->findAll(); 

        return $this->render('evenement/index.html.twig', array(
            'entities' => $entities,
            'nbr' => 20,
        ));
    }

    /**
     * @Route("/show/{id}", name="show", requirements={"id" = "\d+"})
     */
    public function show(Evenement $entity)
    {
        return $this->render('evenement/show.html.twig', array(
            'entity' => $entity,
            'mediaWithPhotoIdent' => $entity->getMediaWithPhotoIdent(),
        ));
    }
}
