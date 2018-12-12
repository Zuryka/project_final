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

use App\Form\EvenementType;
use App\Entity\Evenement;

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
            'newEntity' => new Evenement,
        ));
    }

    /**
     * @Route("/show/{id}", name="show", requirements={"id" = "\d+"})
     */
    public function show($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Evenement::class)->findOneById($id);

        return $this->render('evenement/show.html.twig', array(
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
        // $this->denyAccessUnlessGranted('create', $evenement);

        $entity = new Evenement;
        $entity->setIdUserCreateur($this->getUser());
        $form = $this->createForm(EvenementType::class, $entity);
        $form->handleRequest($request); // Envoi les données de requêtes (POST) au formulaire

        if ($form->isSubmitted() && $form->isValid()) { // Si le form est envoyé et valide
            // Ajout du nouvel evenement dans la db
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity); // Prépare la requête
            $em->flush(); // Execute la requête

            // Crée un message de confirmation
            $this->addFlash('success', $translator->trans('evenement.new.success'));

            // Déclanchement de l'événement 'evenement.add'
            $event = new GenericEvent($entity);
            $eventDispatcher->dispatch('evenement.add', $event);

            return $this->redirectToRoute('evenement_index'); // Retour sur la liste des evenements
        }

        return $this->render('evenement/new.html.twig', array(
            'form' => $form->createView(), // Envoi le formulaire à la vue
        ));
    }

    /**
     * @Route("/edit/{id}", name="edit", requirements={"id" = "\d+"})
     */
    public function edit(Request $request, Evenement $entity, TranslatorInterface $translator)
    {
        // Affiche un deny Access si l'utilisateur ne peut pas modifier
        $this->denyAccessUnlessGranted('edit', $entity);
        // $this->isGranted('edit', $evenement);

        $form = $this->createForm(EvenementType::class, $entity);
        $form->handleRequest($request); // Envoi les données de requêtes (POST) au formulaire

        if ($form->isSubmitted() && $form->isValid()) { // Si le form est envoyé et valide
            // Ajout du nouvel evenement dans la db
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity); // Prépare la requête
            $em->flush(); // Execute la requête

            // Crée un message de confirmation
            $this->addFlash('success', $translator->trans('evenement.edit.success'));

            return $this->redirectToRoute('evenement_index'); // Retour sur la liste des evenements
        }

        return $this->render('evenement/edit.html.twig', array(
            'form' => $form->createView(), // Envoi le formulaire à la vue
            'entity' => $entity,
        ));
    }

    /**
     * @Route("/delete/{id}", name="delete", requirements={"id" = "\d+"})
     */
    public function delete(Request $request, Evenement $evenement): Response
    {
        // Affiche un deny Access si l'utilisateur ne peut pas modifier
        $this->denyAccessUnlessGranted('edit', $evenement);

        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($evenement);
            $em->flush();
        }

        return $this->redirectToRoute('evenement_index');
    }
}
