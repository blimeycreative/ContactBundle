<?php

namespace Oxygen\ContactBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Oxygen\ContactBundle\Entity\Contact
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Oxygen\ContactBundle\Entity\ContactRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Contact {

  /**
   * @var integer $id
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @var string $first_name
   *
   * @ORM\Column(name="name", type="string", length=255)
   */
  private $name;

  /**
   * @var string $email
   *
   * @ORM\Column(name="email", type="string", length=255)
   */
  private $email;
  /**
   * @var string $telephone
   *
   * @ORM\Column(name="telephone", type="string", length=255, nullable=true)
   */
  private $telephone;
  
  /**
   * @var string $company
   *
   * @ORM\Column(name="company", type="string", length=255, nullable=true)
   */
  private $company;
  

  /**
   * @var text $message
   *
   * @ORM\Column(name="message", type="text")
   */
  private $message;

  /**
   * @ORM\ManyToOne(targetEntity="Title", inversedBy="contacts")
   * @ORM\JoinColumn(name="title_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
   * @Assert\Type(type="Oxygen\ContactBundle\Entity\Title")
   */
  protected $title;

  /**
   * @var string $created
   *
   * @ORM\Column(name="created", type="datetime")
   */
  private $created;

  /**
   * @var string $updated
   *
   * @ORM\Column(name="updated", type="datetime")
   */
  private $updated;
  
  private $delete_form;

  /**
   * Get id
   *
   * @return integer 
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set first_name
   *
   * @param string $firstName
   */
  public function setName($name) {
    $this->name = $name;
  }

  /**
   * Get first_name
   *
   * @return string 
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Set email
   *
   * @param string $email
   */
  public function setEmail($email) {
    $this->email = $email;
  }

  /**
   * Get email
   *
   * @return string 
   */
  public function getEmail() {
    return $this->email;
  }

  /**
   * Set message
   *
   * @param text $message
   */
  public function setMessage($message) {
    $this->message = $message;
  }

  /**
   * Get message
   *
   * @return text 
   */
  public function getMessage() {
    return $this->message;
  }

  /**
   * Set title
   *
   * @param Oxygen\ContactBundle\Entity\Title $title
   */
  public function setTitle(\Oxygen\ContactBundle\Entity\Title $title) {
    $this->title = $title;
  }

  /**
   * Get title
   *
   * @return Oxygen\ContactBundle\Entity\Title 
   */
  public function getTitle() {
    return $this->title;
  }

  /**
   * @ORM\prePersist
   */
  public function setTimestamp() {
    $this->created = new \DateTime();
    $this->updated = $this->created;
  }

  /**
   * @ORM\preUpdate
   */
  public function updateTimeStamp() {
    $this->updated = new \DateTime();
  }

  /**
   * Set created
   *
   * @param datetime $created
   */
  public function setCreated($created) {
    $this->created = $created;
  }

  /**
   * Get created
   *
   * @return datetime 
   */
  public function getCreated() {
    return $this->created;
  }

  /**
   * Set updated
   *
   * @param datetime $updated
   */
  public function setUpdated($updated) {
    $this->updated = $updated;
  }

  /**
   * Get updated
   *
   * @return datetime 
   */
  public function getUpdated() {
    return $this->updated;
  }
  
  public function getDeleteForm(){
    return $this->delete_form;
  }
  
  public function setDeleteForm($form){
    $this->delete_form = $form;
  }


    /**
     * Set telephone
     *
     * @param string $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set company
     *
     * @param string $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * Get company
     *
     * @return string 
     */
    public function getCompany()
    {
        return $this->company;
    }
}