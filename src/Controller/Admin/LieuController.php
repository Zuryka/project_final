<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Lieu;
use App\Form\LieuType;

/**
 * @Route("/admin/lieu", name="admin_lieu_")
 */
class LieuController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(Lieu::class)->findAll();

        return $this->render('admin/lieu/index.html.twig', [
            'entities' => $entities,
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request)
    {
        $entity = new Lieu;
        $form = $this->createForm(LieuType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $t = $this->get('translator');
            $this->addFlash('success', $t->trans('lieu.new.success'));

            return $this->redirectToRoute('admin_lieu_index');
        }

        return $this->render('admin/lieu/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Request $request, Lieu $entity)
    {
        $form = $this->createForm(LieuType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $t = $this->get('translator');
            $this->addFlash('success', $t->trans('lieu.edit.success'));

            return $this->redirectToRoute('admin_lieu_index');
        }

        return $this->render('admin/lieu/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", requirements={"id" = "\d+"})
     */
    public function delete(Request $request, Lieu $entity)
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_lieu_delete', ['id' => $entity->getId()])) // action=""
            ->setMethod('DELETE')
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();

            // Crée un message de confirmation
            $t = $this->get('translator');
            $this->addFlash('success', $t->trans('lieu.delete.success'));

            return $this->redirectToRoute('admin_lieu_index');
        }

        return $this->render('admin/lieu/delete.html.twig', array(
            'form' => $form->createView(), // Envoi le formulaire à la vue
            'entity' => $entity,
        ));
    }
}
