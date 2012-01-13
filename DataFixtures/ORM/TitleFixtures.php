<?php

namespace Oxygen\ContactBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Oxygen\ContactBundle\Entity\Title;

class TitleFixtures extends AbstractFixture implements OrderedFixtureInterface {

  public function load($manager) {
    $title1 = new Title();
    $title1->setName('Mr');
    $manager->persist($title1);
    
    $title2 = new Title();
    $title2->setName('Mrs');
    $manager->persist($title2);
    
    $title3 = new Title();
    $title3->setName('Miss');
    $manager->persist($title3);
    
    $title4 = new Title();
    $title4->setName('Ms');
    $manager->persist($title4);
        
    $manager->flush();
    
    $this->addReference('Mr', $title1);
  }
  
  public function getOrder(){
    return 1;
  }

}