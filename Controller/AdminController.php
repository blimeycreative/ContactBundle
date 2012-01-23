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

/**
 * @Route("/admin/contact")
 */
class AdminController extends Controller {

  /**
   * @Route("/delete/{id}", name="delete_contact")
   * @Template
   */
  public function deleteAction($id) {
    if ($this->getRequest()->getMethod() == 'POST') {
      $contact = $this->getDoctrine()
              ->getRepository('OxygenContactBundle:Contact')
              ->find($id);
      if (!$contact)
        throw $this->createNotFoundException('No contact found for id: #' . $id);
      $form = $this->createDeleteForm($id);
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($contact);
        $em->flush();
        $this->get('session')->setFlash('notice', 'Contact has been deleted');
      }
    }
    return new RedirectResponse($this->generateUrl('show_contacts'));
  }

  /**
   * @Route("/show/{id}", name="show_contact")
   * @Template
   */
  public function showAction($id) {
    $contact = $this->getDoctrine()->getRepository('OxygenContactBundle:Contact')->find($id);
    if (!$contact)
      throw $this->createNotFoundException('No contact found for id: #' . $id);
    return array('contact' => $contact);
  }

  /**
   * @Route("/{page}", name="show_contacts", defaults={"page" = 1})
   * @Template
   */
  public function indexAction(Request $request) {
    $contact_query = $this->getDoctrine()
            ->getRepository('OxygenContactBundle:Contact')
            ->createQueryBuilder('c')
            ->leftJoin('c.title', 't');
    $pager = $this->get('oxygen.utility.pagination.factory')
            ->paginate($contact_query, 2, 'c')
            ->getPagination();
    $contacts = $pager->result->getResult();
    foreach ($contacts as $contact)
      $contact->setDeleteForm($this->createDeleteForm($contact->getId())->createView());
    return array(
        'contacts' => $contacts,
        'pagination' => $pager->template
    );
  }

  private function createDeleteForm($id) {
    return $this->createFormBuilder(array('id' => $id))
                    ->add('id', 'hidden')
                    ->getForm();
  }

}
