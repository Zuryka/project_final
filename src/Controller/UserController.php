<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

//use App\Form\Admin\UserType as AdminUserType;
use App\Form\UserType;
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

    /**
     * @Route("/edit/{username}", name="edit")
     */
    public function edit(Request $request, User $entity)
    {
        $form = $this->createForm(UserType::class, $entity);
        $form->handleRequest($request); // Envoie les données de requêtes (en POST) au formulaire

        if ($form->isSubmitted() && $form->isValid()) { // Si le formulaire est envoyé et valide
            // Ajout des modifications dans la BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $t = $this->get('translator');
            $this->addFlash('success', $t->trans('user.edit.success'));

            return $this->redirectToRoute('user_show');    // retour à la fiche de l'utilisateur
        }
        //$entity = $em->getRepository(User::class)->findOneByUsername($username);
        return $this->render('/user/edit.html.twig', array(
            'form' => $form->createView(),
            'entity' => $entity,
        ));
    }

    /**
     * @Route("/delete/{username}", name="delete")
     */
    public function delete(Request $request, User $entity)
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', ['username' => $entity->getUsername()]))
            ->setMethod('DELETE')
            ->getForm()
        ;

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();

            $t = $this->get('translator');
            $this->addFlash('success', $t->trans('user.delete.success'));

            return $this->redirectToRoute('user_show');
        }
        return $this->render('user/delete.html.twig', array(
            'form' => $form->createView(),  // Envoi le formulaire à la vue
            'entity' => $entity,
        ));
    }
}
