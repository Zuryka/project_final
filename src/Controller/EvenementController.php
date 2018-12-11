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
        return $this->render('evenement/index.html.twig', [
            'controller_name' => 'EvenementController',
        ]);
    }

    /**
     * @Route("/show/{id}", name="show", requirements={"id" = "\d+"})
     */
    public function show(Evenement $entity)
    {
        return $this->render('evenement/show.html.twig', array(
            'entity' => $entity,
        ));
    }
}
