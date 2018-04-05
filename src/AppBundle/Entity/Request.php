<?php
/**
 * Request entity class file
 *
 * PHP Version 7.1
 *
 * @category Entity
 * @package  AppBundle\Entity
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use Swagger\Annotations as SWG;

/**
 * Request
 *
 * @ORM\Table(name="request")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RequestRepository")
 */
class Request
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @SWG\Property(type="integer", description="The unique identifier of the request.")
     *
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     *
     * @SWG\Property(type="string", description="The title of the request.")
     *
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", length=255)
     *
     * @SWG\Property(type="string", description="The text of the request.")
     */
    private $text;

    /**
     * @var int
     *
     * @ORM\Column(name="angle", type="integer", nullable=true)
     *
     * @SWG\Property(type="integer", description="The angle of the request.")
     */
    private $angle;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="requests")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="set null")
     *
     * @SWG\Property(type="User", description="The user linked to the request.")
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
     * @return Request
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
     * Set text
     *
     * @param string $text
     *
     * @return Request
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set angle
     *
     * @param integer $angle
     *
     * @return Request
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
}

