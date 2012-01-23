<?php

namespace Oxygen\ContactBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Oxygen\ContactBundle\Entity\Title
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Oxygen\ContactBundle\Entity\TitleRepository")
 */
class Title {

  /**
   * @var integer $id
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\OneToMany(targetEntity="Contact", mappedBy="Title")
   */
  protected $contacts;

  /**
   * @var string $name
   * @Assert\NotBlank()
   * @ORM\Column(name="name", type="string", length=255)
   */
  private $name;

  public function __construct() {
    $this->contacts = new ArrayCollection();
  }

  public function __toString() {
    return $this->name;
  }

  /**
   * Get id
   *
   * @return integer 
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set name
   *
   * @param string $name
   */
  public function setName($name) {
    $this->name = $name;
  }

  /**
   * Get name
   *
   * @return string 
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Add contacts
   *
   * @param Oxygen\ContactBundle\Entity\Contact $contacts
   */
  public function addContact(\Oxygen\ContactBundle\Entity\Contact $contacts) {
    $this->contacts[] = $contacts;
  }

  /**
   * Get contacts
   *
   * @return Doctrine\Common\Collections\Collection 
   */
  public function getContacts() {
    return $this->contacts;
  }

}