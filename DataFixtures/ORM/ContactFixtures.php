<?php

namespace Oxygen\ContactBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Oxygen\ContactBundle\Entity\Title;
use Oxygen\ContactBundle\Entity\Contact;
use Doctrine\Common\Persistence\ObjectManager;

class ContactFixtures extends AbstractFixture implements OrderedFixtureInterface {

  public function load(ObjectManager $manager) {
    $contact = new Contact();
    $contact->setTitle($manager->merge($this->getReference('Mr')));
    $contact->setName('Test McTester');
    $contact->setEmail('test@mctester.com');
    $contact->setMessage('Example message from a user making an enquiry from the contact form');
    $manager->persist($contact);
        
    $manager->flush();
  }
  
  public function getOrder(){
    return 2;
  }

}