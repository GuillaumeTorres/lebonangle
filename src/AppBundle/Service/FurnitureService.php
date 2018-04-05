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

use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Furniture;
use AppBundle\Entity\User;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

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

    /**
     * @return \AppBundle\Entity\Furniture[]|array
     */
    public function getFurnitures()
    {
        return $this
            ->entityManager
            ->getRepository('AppBundle:Furniture')
            ->findAll();
    }

    /**
     * @param integer $id
     *
     * @return Furniture|array|Object
     */
    public function getById($id)
    {
        return $this
            ->entityManager
            ->getRepository('AppBundle:Furniture')
            ->findOneBy(['id' => $id]);
    }

    /**
     * @param Request $request
     */
    public function insertRequest($request)
    {
        $this->entityManager->persist($request);
        $this->entityManager->flush();
    }

    /**
     * @param integer $id
     */
    public function deleteFurniture($id)
    {
        $furniture = $this
            ->entityManager
            ->getRepository('AppBundle:Furniture')
            ->findOneBy(['id' => $id]);

        $this->entityManager->remove($furniture);
        $this->entityManager->flush();
    }
}