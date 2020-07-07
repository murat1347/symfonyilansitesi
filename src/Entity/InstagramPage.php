<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InstagramPageRepository")
 */
class InstagramPage
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $pageName;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(name="is_vertified", type="boolean")
     */
    private $isVertified;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $pageLink;

    /**
     * @ORM\Column(type="string",length=150)
     */
    private $imageLink;

    /**
     * @ORM\Column(type="string",length=400)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * Many Users have Many Groups.
     * @ORM\ManyToMany(targetEntity="Category")
     * @ORM\JoinTable(name="instagram_page_categories",
     * joinColumns={@ORM\JoinColumn(name="instagram_page_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     * )
     */
    private $categories;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getPageName()
    {
        return $this->pageName;
    }

    public function setPageName($pageName)
    {
        $this->pageName = $pageName;
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    public function getIsVertified()
    {
        return $this->isVertified;
    }

    public function setIsVertified($isVertified)
    {
        $this->isVertified = $isVertified;
        return $this;
    }

    public function getPageLink()
    {
        return $this->pageLink;
    }

    public function setPageLink($pageLink)
    {
        $this->pageLink = $pageLink;
        return $this;
    }

    public function getImageLink()
    {
        return $this->imageLink;
    }

    public function setImageLink($imageLink)
    {
        $this->imageLink = $imageLink;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function setCategories($categories)
    {
        $this->categories = $categories;
        return $this;
    }
} 