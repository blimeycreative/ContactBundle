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
class ClientController extends Controller {

  /**
   * @Route("/thank-you", name="contact_thankyou")
   * @Template
   */
  public function thankyouAction() {
    return array();
  }
  
  /**
   * @Route("/{blank_layout}", name="new_contact", defaults={"blank_layout" = false})
   * @Template
   */
  public function contactAction($blank_layout) {
    $em = $this->getDoctrine()->getEntityManager();
    $contact = new Contact();
    $class = $this->container->getParameter('oxygen.contact.contact.type');
    $form = $this->createForm(new $class($this->container), $contact);
    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em->persist($contact);
        $em->flush();
        $message = \Swift_Message::newInstance()
                ->setSubject('Contact form')
                ->setFrom($this->container->getParameter('contact.from.email'))
                ->setTo($contact->getEmail())
                ->setBody($this->renderView('OxygenContactBundle:Email:user.html.twig', array(
                    'name' => $contact->getName())
                ), 'text/html');
        $this->get('mailer')->send($message);
        $message = \Swift_Message::newInstance()
                ->setSubject('Contact form')
                ->setFrom($this->container->getParameter('contact.from.email'))
                ->setTo($this->container->getParameter('contact.to.email'))
                ->setBody($this->renderView('OxygenContactBundle:Email:admin.html.twig', array(
                    'contact' => $contact)
                ), 'text/html');
        $this->get('mailer')->send($message);
        $this->get('session')->setFlash('notice', 'Thank you for contacting us');

        return new RedirectResponse($this->generateUrl('contact_thankyou'));
      }
    }
    $params = array('form' => $form->createView(), 'blank_layout' => $blank_layout);
    if ($blank_layout)
      return $this->render('OxygenContactBundle:Client:contact-form.html.twig', $params);
    return $this->render('OxygenContactBundle:Client:contact.html.twig', $params);
  }

  

}