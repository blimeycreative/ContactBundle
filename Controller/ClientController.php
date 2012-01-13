<?php

namespace Oxygen\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Oxygen\ContactBundle\Entity\Contact;
use Oxygen\ContactBundle\Form\ContactType;
use Oxygen\ContactBundle\Utility\Useful;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * @Route("/contact")
 */
class ClientController extends Controller{
  
  /**
   * @Route("/", name="new_contact")
   * @Template
   */
  public function contactAction(Request $request) {
    $em = $this->getDoctrine()->getEntityManager();
    $contact = new Contact();
    $form = $this->createForm(new ContactType(), $contact);
    if ($request->getMethod() == 'POST') {
      $form->bindRequest($request);
      if ($form->isValid()) {
        $em->persist($contact);
        $em->flush();
        $message = \Swift_Message::newInstance()
                ->setSubject('Contact form')
                ->setFrom(Useful::$email)
                ->setTo($contact->getEmail())
                ->setBody($this->renderView('OxygenContactBundle:Email:user.html.twig', array(
                    'name' => $contact->getName())
                ), 'text/html');
        $this->get('mailer')->send($message);
        $message = \Swift_Message::newInstance()
                ->setSubject('Contact form')
                ->setFrom(Useful::$site_email)
                ->setTo(Useful::$email)
                ->setBody($this->renderView('OxygenContactBundle:Email:admin.html.twig', array(
                    'contact' => $contact)
                ), 'text/html');
        $this->get('mailer')->send($message);
        $this->get('session')->setFlash('notice', 'Thank you for contacting us');

        return new RedirectResponse($this->generateUrl('contact_thankyou'));
      }
    }
    return array('form' => $form->createView());
  }
  
  /**
   * @Route("/thank-you", name="contact_thankyou")
   * @Template
   */
  public function thankyouAction() {
    return array();
  }
}