<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;

/**
 * @Route("/user", name="user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(User::class)->findAll();

        return $this->render('user/index.html.twig', [
            //'controller_name' => 'UserController',
            'entities' => $entities,
        ]);
    }

    /**
     * @Route("/show/{username}", name="show")
     */
    public function show($username)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(User::class)->findOneByUsername($username);
        return $this->render('/user/show.html.twig', array(
            'entity' => $entity,
        ));
    }
}
