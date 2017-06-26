<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Fitxategia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Fitxategium controller.
 *
 * @Route("/")
 */
class FitxategiaController extends Controller
{

    /**
     * Creates a new fitxategium entity.
     *
     * @Route("/", name="fitxategia_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $fitxategium = new Fitxategia();
        $form = $this->createForm('AppBundle\Form\FitxategiaType', $fitxategium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fitxategium);
            $em->flush();

            return $this->redirectToRoute('fitxategia_show', array('id' => $fitxategium->getId()));
        }

        return $this->render('fitxategia/new.html.twig', array(
            'fitxategium' => $fitxategium,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a fitxategium entity.
     *
     * @Route("/{id}", name="fitxategia_show")
     * @Method("GET")
     * @param Fitxategia $fitxategium
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Fitxategia $fitxategium)
    {
        $deleteForm = $this->createDeleteForm($fitxategium);

        return $this->render('fitxategia/show.html.twig', array(
            'fitxategium' => $fitxategium,
            'delete_form' => $deleteForm->createView(),
        ));
    }


}
