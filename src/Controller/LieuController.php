<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route; // Définir les routes en annotations
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Translation\TranslatorInterface;

use App\Form\LieuType;
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
            'newEntity' => new Lieu, // Pour tester avec le voter
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
            'mediaWithPhotoIdent' => $entity->getMediaWithPhotoIdent(),
        ));
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request, EventDispatcherInterface $eventDispatcher, TranslatorInterface $translator)
    {
        // Affiche un deny Access si l'utilisateur ne peut pas modifier
        // $this->denyAccessUnlessGranted('create', $lieu);

        $entity = new Lieu;
        $entity->setUserCreateur($this->getUser());
        $form = $this->createForm(LieuType::class, $entity);
        $form->handleRequest($request); // Envoi les données de requêtes (POST) au formulaire

        if ($form->isSubmitted() && $form->isValid()) { // Si le form est envoyé et valide

            $photoIdent = $form->get("photoIdent")->getData();
            var_dump($photoIdent);
            //$entity->addMedia($photoIdent);

            // Ajout du nouvel lieu dans la db
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity); // Prépare la requête
            $em->flush(); // Execute la requête

            // Crée un message de confirmation
            $this->addFlash('success', $translator->trans('lieu.new.success'));

            // Déclanchement de l'événement 'lieu.add'
            $event = new GenericEvent($entity);
            $eventDispatcher->dispatch('lieu.add', $event);

            return $this->redirectToRoute('lieu_index'); // Retour sur la liste des lieux
        }

        return $this->render('lieu/new.html.twig', array(
            'form' => $form->createView(), // Envoi le formulaire à la vue
        ));
    }

    /**
     * @Route("/edit/{id}", name="edit", requirements={"id" = "\d+"})
     */
    public function edit(Request $request, Lieu $entity, TranslatorInterface $translator)
    {
        // Affiche un deny Access si l'utilisateur ne peut pas modifier
        $this->denyAccessUnlessGranted('edit', $entity);
        // $this->isGranted('edit', $lieu);

        $form = $this->createForm(LieuType::class, $entity);
        $form->handleRequest($request); // Envoi les données de requêtes (POST) au formulaire

        if ($form->isSubmitted() && $form->isValid()) { // Si le form est envoyé et valide
            // Ajout du nouvel lieu dans la db
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity); // Prépare la requête
            $em->flush(); // Execute la requête

            // Crée un message de confirmation
            $this->addFlash('success', $translator->trans('lieu.edit.success'));

            return $this->redirectToRoute('lieu_index'); // Retour sur la liste des lieux
        }

        return $this->render('lieu/edit.html.twig', array(
            'form' => $form->createView(), // Envoi le formulaire à la vue
            'entity' => $entity,
        ));
    }

    /**
     * @Route("/delete/{id}", name="delete", requirements={"id" = "\d+"})
     */
    public function delete(Request $request, Lieu $lieu): Response
    {
        // Affiche un deny Access si l'utilisateur ne peut pas modifier
        $this->denyAccessUnlessGranted('edit', $lieu);

        if ($this->isCsrfTokenValid('delete'.$lieu->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lieu);
            $em->flush();
        }

        return $this->redirectToRoute('lieu_index');
    }
}
