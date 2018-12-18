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

use App\Form\FormationType;
use App\Entity\Formation;

/**
 * @Route("/formation", name="formation_")
 */
class FormationController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(Formation::class)->findAll(); 

        return $this->render('formation/index.html.twig', array(
            'entities' => $entities,
            'newEntity' => new Formation,
        ));
    }

    /**
     * @Route("/show/{id}", name="show", requirements={"id" = "\d+"})
     */
    public function show($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Formation::class)->findOneById($id);

        return $this->render('formation/show.html.twig', array(
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
        // $this->denyAccessUnlessGranted('create', $formation);

        $entity = new Formation;
        $entity->setUserCreateur($this->getUser());
        $form = $this->createForm(FormationType::class, $entity);
        $form->handleRequest($request); // Envoi les données de requêtes (POST) au formulaire

        if ($form->isSubmitted() && $form->isValid()) { // Si le form est envoyé et valide
            // Ajout du nouvel formation dans la db
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity); // Prépare la requête
            $em->flush(); // Execute la requête

            // Crée un message de confirmation
            $this->addFlash('success', $translator->trans('formation.new.success'));

            // Déclanchement de l'événement 'formation.add'
            $event = new GenericEvent($entity);
            $eventDispatcher->dispatch('formation.add', $event);

            return $this->redirectToRoute('formation_index'); // Retour sur la liste des formations
        }

        return $this->render('formation/new.html.twig', array(
            'form' => $form->createView(), // Envoi le formulaire à la vue
        ));
    }

    /**
     * @Route("/edit/{id}", name="edit", requirements={"id" = "\d+"})
     */
    public function edit(Request $request, Formation $entity, TranslatorInterface $translator)
    {
        // Affiche un deny Access si l'utilisateur ne peut pas modifier
        $this->denyAccessUnlessGranted('edit', $entity);
        // $this->isGranted('edit', $formation);

        $form = $this->createForm(FormationType::class, $entity);
        $form->handleRequest($request); // Envoi les données de requêtes (POST) au formulaire

        if ($form->isSubmitted() && $form->isValid()) { // Si le form est envoyé et valide
            // Ajout du nouvel formation dans la db
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity); // Prépare la requête
            $em->flush(); // Execute la requête

            // Crée un message de confirmation
            $this->addFlash('success', $translator->trans('formation.edit.success'));

            return $this->redirectToRoute('formation_index'); // Retour sur la liste des formations
        }

        return $this->render('formation/edit.html.twig', array(
            'form' => $form->createView(), // Envoi le formulaire à la vue
            'entity' => $entity,
        ));
    }

    /**
     * @Route("/delete/{id}", name="delete", requirements={"id" = "\d+"})
     */
    public function delete(Request $request, Formation $formation): Response
    {
        // Affiche un deny Access si l'utilisateur ne peut pas modifier
        $this->denyAccessUnlessGranted('edit', $formation);

        if ($this->isCsrfTokenValid('delete'.$formation->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($formation);
            $em->flush();
        }

        return $this->redirectToRoute('formation_index');
    }
}
