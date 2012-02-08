<?php

namespace Oxygen\ContactBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ContactType extends AbstractType {

  private $fields = array(
      'title' => array(
          'entity',
          array(
              'class' => 'OxygenContactBundle:Title'
          )
      ),
      'name' => array('text', array()),
      'email' => array('email', array()),
      'telephone' => array('text', array('required'=>false)),
      'company' => array('text', array('required'=>false)),
      'message' => array('textarea', array()),
  );

  public function __construct($container) {
    foreach ($this->fields as $field_name => $data)
      if (!in_array($field_name, $container->getParameter('contact.form.fields')))
        unset($this->fields[$field_name]);
  }

  public function buildForm(FormBuilder $builder, array $options) {
    foreach($this->fields as $field_name => $data)
      $builder->add ($field_name, $data[0], $data[1]);
  }

  public function getName() {
    return 'contact';
  }

  public function getDefaultOptions(array $options) {
    return array('data_class' => 'Oxygen\ContactBundle\Entity\Contact');
  }

}
