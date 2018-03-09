<?php
/**
 * User entity class file
 *
 * PHP Version 7.1
 *
 * @category Entity
 * @package  AppBundle\Entity
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="type", columnDefinition="ENUM('BUYER','SELLER')", type="string", length=255)
     */
    private $type;

    /**
     * @var Furniture
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Furniture", mappedBy="user")
     */
    private $furnitures;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->furnitures = new ArrayCollection();
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id'         => $this->getId(),
            'username'   => $this->getUsername(),
            'first_name' => $this->getFirstName(),
            'last_name'  => $this->getLastName(),
            'type'       => $this->getType(),
            'email'      => $this->getEmail(),
            'roles'      => $this->getRoles(),
        ];
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return Furniture
     */
    public function getFurnitures()
    {
        return $this->furnitures;
    }

    /**
     * Add Furniture
     *
     * @param Furniture $furniture
     *
     * @return User
     */
    public function addFurniture(Furniture $furniture)
    {
        $this->furnitures[] = $furniture;

        return $this;
    }

    /**
     * Remove Furniture
     *
     * @param Furniture $furniture
     */
    public function removeFurniture(Furniture $furniture)
    {
        $this->furnitures->removeElement($furniture);
    }
}

