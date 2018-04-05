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
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Swagger\Annotations as SWG;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 *
 * @ExclusionPolicy("all")
 */
class User extends BaseUser implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @SWG\Property(type="integer", description="The unique identifier of the user.")
     *
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255)
     *
     * @SWG\Property(type="string", description="The First Name of the user.")
     *
     * @Expose
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     *
     * @SWG\Property(type="string", description="The Last Name of the user.")
     *
     * @Expose
     */
    private $lastName;

    /**
     * @var int
     *
     * @ORM\Column(name="phone_number", type="integer", nullable=true)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="type", columnDefinition="ENUM('BUYER','SELLER')", type="string", length=255)
     *
     * @SWG\Property(type="string", description="The Type of the user.")
     *
     * @Expose
     */
    private $type;

    /**
     * @var Furniture
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Furniture", mappedBy="user")
     *
     * @SWG\Property(type="array", description="The Furnitures of the user.")
     */
    private $furnitures;

    /**
     * @var Request
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Request", mappedBy="user")
     *
     * @SWG\Property(type="array", description="The Requests of the user.")
     */
    private $requests;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->furnitures = new ArrayCollection();
        $this->requests   = new ArrayCollection();
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id'           => $this->getId(),
            'username'     => $this->getUsername(),
            'first_name'   => $this->getFirstName(),
            'last_name'    => $this->getLastName(),
            'type'         => $this->getType(),
            'email'        => $this->getEmail(),
            'phone_number' => $this->getPhoneNumber(),
            'roles'        => $this->getRoles(),
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

    /**
     * @return Request
     */
    public function getRequests()
    {
        return $this->requests;
    }

    /**
     * @param Request $request
     */
    public function addRequests(Request $request)
    {
        $request->setUser($this);
        $this->requests[] = $request;
    }

    /**
     * Remove Request
     *
     * @param Request $requests
     */
    public function removeRequest(Request $requests)
    {
        $this->requests->removeElement($requests);
    }

    /**
     * @return int|null
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param int $phoneNumber
     */
    public function setPhoneNumber(int $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }
}

