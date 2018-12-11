<?php

namespace App\Controller\Admin;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\UserBundle\Model\UserManagerInterface;

/**
 * @Route("/admin/evenement")
 */
class EvenementController extends AbstractController
{
    /**
     * @Route("/", name="admin_evenement_index", methods="GET")
     */
    public function index(EvenementRepository $evenementRepository): Response
    {
        return $this->render('admin/evenement/index.html.twig', ['evenements' => $evenementRepository->findAll()]);
    }

    /**
     * @Route("/new", name="admin_evenement_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $evenement = new Evenement;

        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em  = $this->getDoctrine()->getManager();
            $em->persist($evenement); //Prépare la requête 
            $em->flush();

            return $this->redirectToRoute('admin_evenement_index');
        }

        return $this->render('admin/evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_evenement_show", methods="GET")
     */
    public function show(Evenement $evenement): Response
    {
        return $this->render('admin/evenement/show.html.twig', ['evenement' => $evenement]);
    }

    /**
     * @Route("/{id}/edit", name="admin_evenement_edit", methods="GET|POST")
     */
    public function edit(Request $request, Evenement $evenement): Response
    {
        //$evenementManager = $this->get('fos_evenement.evenement_manager');
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em  = $this->getDoctrine()->getManager();
            $em->persist($entity); //Prépare la requête 
            $em->flush();

            return $this->redirectToRoute('admin_evenement_index', ['id' => $evenement->getId()]);
        }

        return $this->render('admin/evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_evenement_delete", methods="DELETE")
     */
    public function delete(Request $request, Evenement $evenement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($evenement);
            $em->flush();
        }

        return $this->redirectToRoute('admin_evenement_index');
    }
}
