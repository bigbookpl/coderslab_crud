<?php

namespace CodersLabBundle\Controller;

use CodersLabBundle\Entity\Phoneboook;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Phoneboook controller.
 *
 * @Route("phoneboook")
 */
class PhoneboookController extends Controller
{
    /**
     * Lists all phoneboook entities.
     *
     * @Route("/", name="phoneboook_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $phoneboooks = $em->getRepository('CodersLabBundle:Phoneboook')->findAll();

        return $this->render('phoneboook/index.html.twig', array(
            'phoneboooks' => $phoneboooks,
        ));
    }

    /**
     * Creates a new phoneboook entity.
     *
     * @Route("/new", name="phoneboook_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $phoneboook = new Phoneboook();
        $form = $this->createForm('CodersLabBundle\Form\PhoneboookType', $phoneboook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($phoneboook);
            $em->flush($phoneboook);

            return $this->redirectToRoute('phoneboook_show', array('id' => $phoneboook->getId()));
        }

        return $this->render('phoneboook/new.html.twig', array(
            'phoneboook' => $phoneboook,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a phoneboook entity.
     *
     * @Route("/{id}", name="phoneboook_show")
     * @Method("GET")
     */
    public function showAction(Phoneboook $phoneboook)
    {
        $deleteForm = $this->createDeleteForm($phoneboook);

        return $this->render('phoneboook/show.html.twig', array(
            'phoneboook' => $phoneboook,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing phoneboook entity.
     *
     * @Route("/{id}/edit", name="phoneboook_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Phoneboook $phoneboook)
    {
        $deleteForm = $this->createDeleteForm($phoneboook);
        $editForm = $this->createForm('CodersLabBundle\Form\PhoneboookType', $phoneboook);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('phoneboook_edit', array('id' => $phoneboook->getId()));
        }

        return $this->render('phoneboook/edit.html.twig', array(
            'phoneboook' => $phoneboook,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a phoneboook entity.
     *
     * @Route("/{id}", name="phoneboook_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Phoneboook $phoneboook)
    {
        $form = $this->createDeleteForm($phoneboook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($phoneboook);
            $em->flush($phoneboook);
        }

        return $this->redirectToRoute('phoneboook_index');
    }

    /**
     * Creates a form to delete a phoneboook entity.
     *
     * @param Phoneboook $phoneboook The phoneboook entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Phoneboook $phoneboook)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('phoneboook_delete', array('id' => $phoneboook->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
