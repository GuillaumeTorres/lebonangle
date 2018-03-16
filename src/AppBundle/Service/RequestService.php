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
use AppBundle\Entity\User;
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
     * @param User  $user
     * @param array $parameters
     *
     * @return Request
     */
    public function createRequest($user, $parameters)
    {
        $request = new Request();
        $request->setTitle($parameters['title']);
        $request->setText($parameters['text']);
        $request->setAngle($parameters['angle']);
        $request->setUser($user);

        $this->entityManager->persist($request);
        $this->entityManager->flush();

        return $request;
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
