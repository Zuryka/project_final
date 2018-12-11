<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Lieu;

/**
 * @Route("/lieu", name="lieu_")
 */
class LieuController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(Lieu::class)->findAll();

        return $this->render('lieu/index.html.twig', [
            'entities' => $entities,
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Lieu::class)->findOneById($id);
        return $this->render('/lieu/show.html.twig', array(
            'entity' => $entity,
        ));
    }
}
