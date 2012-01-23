<?php

namespace Oxygen\ContactBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TitleType extends AbstractType {

  public function buildForm(FormBuilder $builder, array $options) {
    $builder->add('name');
  }
  
  public function getName(){
    return 'title';
  }

  public function getDefaultOptions(array $options){
    return array('data_class' => 'Oxygen\ContactBundle\Entity\Title');
  }
  
}
