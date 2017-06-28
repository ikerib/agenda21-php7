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
            $fitxategium->setCreated( new \DateTime() );
            $em->persist($fitxategium);
            $em->flush();


            /**
             * Emaila bidali
             */

            $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
            $path = $helper->asset($fitxategium, 'uploadfile');
            $filename = $request->getUriForPath($path);
            $message = \Swift_Message::newInstance()
                ->setSubject('Agenda 21 irudi berria')
                ->setFrom('agenda21@pasaia.org')
                ->setTo('iibarguren@pasaia.net')
                ->setBody(
                    $this->renderView(
                        'Emails/info.html.twig',
                        array(
                            'filename' => $filename,
                            'fitxategia' => $fitxategium
                            )
                    ),
                    'text/html'
                )
            ;
            $this->get('mailer')->send($message);


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
     * @Route("/ok", name="fitxategia_show")
     * @Method("GET")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction()
    {
        return $this->render('fitxategia/show.html.twig', array(

        ));
    }


}
