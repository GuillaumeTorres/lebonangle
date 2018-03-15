<?php
/**
 * FurnitureService file
 *
 * PHP Version 7.1
 *
 * @category Service
 *
 * @package  AppBundle\Service
 */
namespace AppBundle\Service;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

/**
 * Class FurnitureService
 */
class FurnitureService
{
    private $entityManager;

    /**
     * UserService constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager  = $entityManager;
    }
}