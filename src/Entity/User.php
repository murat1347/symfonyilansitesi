<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $city;

    
    /**
     * @ORM\Column(type="string", length=60)
     */
    private $firstName;
    
    /**
     * @ORM\Column(type="string", length=60)
     */
    private $secondName;
    
    
    
    
    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * One Product has Many Features.
     * @ORM\OneToMany(targetEntity="FacebookPage", mappedBy="user")
     */
    private $facebookPages;

    /**
     * One Product has Many Features.
     * @ORM\OneToMany(targetEntity="TwitterPage", mappedBy="user")
     */
    private $TwitterPages;
    
    
    /**
     * One Product has Many Features.
     * @ORM\OneToMany(targetEntity="InstagramPage", mappedBy="user")
     */
    private $Instagrampages;
    
    public function __construct()
    {
        $this->isActive = true;
        $this->facebookPages = new \Doctrine\Common\Collections\ArrayCollection();
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid('', true));
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
        return array(
            'ROLE_USER'
        );
    }

    public function eraseCredentials()
    {}

    /**
     *
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password
            // see section on salt below
            // $this->salt,
        ));
    }

    /**
     *
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list ($this->id, $this->username, $this->password, ) = 
        // see section on salt below
        // $this->salt
        unserialize($serialized);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getİd()
    {
        return $this->id;
    }

    public function setİd($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    public function getİsActive()
    {
        return $this->isActive;
    }

    public function setİsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }



  public function getFacebookPages(){
    return $this->facebookPages;
  }

  public function setFacebookPages($facebookPages){
    $this->facebookPages = $facebookPages;
    return $this;
  }


  


  public function getFirstName(){
    return $this->firstName;
  }

  public function setFirstName($firstName){
    $this->firstName = $firstName;
    return $this;
  }

  public function getSecondName(){
    return $this->secondName;
  }

  public function setSecondName($secondName){
    $this->secondName = $secondName;
    return $this;
  }


  public function getTwitterPages(){
    return $this->TwitterPages;
  }

  public function setTwitterPages($TwitterPages){
    $this->TwitterPages = $TwitterPages;
    return $this;
  }

  public function getInstagrampages(){
    return $this->Instagrampages;
  }

  public function setInstagrampages($Instagrampages){
    $this->Instagrampages = $Instagrampages;
    return $this;
  }

}
