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




use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Furniture;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
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
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of all the furnitures.",
     *     @SWG\Schema(
     *          type="array",
     *          @Model(type=Furniture::class)
     *      )
     * )
     *
     * @SWG\Tag(name="Furnitures")
     *
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
     * @SWG\Response(
     *     response=200,
     *     description="Returns the furniture with the specified id.",
     *     @SWG\Schema(
     *          type="array",
     *          @Model(type=Furniture::class)
     *      )
     * )
     *
     * @SWG\Tag(name="Furnitures")
     *
     * @Rest\Get("/furniture/{id}", name="furniture")
     *
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
}