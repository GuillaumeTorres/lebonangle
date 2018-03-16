<?php
/**
 * Furniture entity class file
 *
 * PHP Version 7.1
 *
 * @category Entity
 *
 * @package  AppBundle\Entity
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use Swagger\Annotations as SWG;

/**
 * Furniture
 *
 * @ORM\Table(name="furniture")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FurnitureRepository")
 */
class Furniture
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @SWG\Property(type="integer", description="The unique identifier of the furniture.")
     *
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     *
     * @SWG\Property(type="string", description="The title of the furniture.")
     *
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     *
     * @SWG\Property(type="string", description="The description of the furniture.")
     *
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="width", type="float")
     *
     * @SWG\Property(type="float", description="The width of the furniture.")
     */
    private $width;

    /**
     * @var float
     *
     * @ORM\Column(name="height", type="float")
     *
     * @SWG\Property(type="float", description="The height of the furniture.")
     */
    private $height;

    /**
     * @var float
     *
     * @ORM\Column(name="depth", type="float")
     *
     * @SWG\Property(type="float", description="The depth of the furniture.")
     */
    private $depth;

    /**
     * @var int
     *
     * @ORM\Column(name="angle", type="integer", nullable=true)
     *
     * @SWG\Property(type="integer", description="The angle of the furniture.")
     */
    private $angle;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="furnitures")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="set null")
     *
     * @SWG\Property(type="User", description="The user linked to the furniture.")
     *
     * @Exclude
     */
    private $user;

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
     * Set title
     *
     * @param string $title
     *
     * @return Furniture
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Furniture
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set width
     *
     * @param float $width
     *
     * @return Furniture
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return float
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param float $height
     *
     * @return Furniture
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return float
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set depth
     *
     * @param float $depth
     *
     * @return Furniture
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;

        return $this;
    }

    /**
     * Get depth
     *
     * @return float
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * Set angle
     *
     * @param integer $angle
     *
     * @return Furniture
     */
    public function setAngle($angle)
    {
        $this->angle = $angle;

        return $this;
    }

    /**
     * Get angle
     *
     * @return int
     */
    public function getAngle()
    {
        return $this->angle;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return array
     * */
    public function jsonSerialize()
    {
        return [
            'id'          => $this->getId(),
            'title'       => $this->getTitle(),
            'description' => $this->getDescription(),
            'width'       => $this->getWidth(),
            'height'      => $this->getHeight(),
            'depth'       => $this->getDepth(),
            'angle'       => $this->getAngle(),
        ];
    }
}

