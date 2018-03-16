<?php
/**
 * RequestService file
 *
 * PHP Version 7.1
 *
 * @category Service
 *
 * @package  AppBundle\Service
 */
namespace AppBundle\Service;

use AppBundle\Entity\Request;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class RequestService
 */
class RequestService
{
    private $entityManager;

    /**
     * RequestService constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager  = $entityManager;
    }

    /**
     * @param integer $userId
     *
     * @return Request[]|array
     */
    public function getByUser($userId)
    {
        return $this
            ->entityManager
            ->getRepository('AppBundle:Request')
            ->findBy(['user' => $userId]);
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
    public function deleteRequest($id)
    {
        $request = $this
            ->entityManager
            ->getRepository('AppBundle:Request')
            ->findOneBy(['id' => $id]);

        $this->entityManager->remove($request);
        $this->entityManager->flush();
    }
}
