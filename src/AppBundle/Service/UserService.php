<?php
/**
 * UserService file
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
 * Class UserService
 */
class UserService
{
    private $entityManager;
    private $encoderFactory;
    private $userManager;

    /**
     * UserService constructor.
     *
     * @param EntityManagerInterface  $entityManager
     * @param EncoderFactoryInterface $encoderFactory
     * @param UserManagerInterface    $userManager
     */
    public function __construct(EntityManagerInterface $entityManager, EncoderFactoryInterface $encoderFactory, UserManagerInterface $userManager)
    {
        $this->entityManager  = $entityManager;
        $this->encoderFactory = $encoderFactory;
        $this->userManager    = $userManager;
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return User
     */
    public function authUser($username, $password)
    {
        /** @var User $user */
        $user = $this->userManager->findUserByUsername($username);

        if (!$user) {
            throw new NotFoundResourceException(sprintf('user %s not found', $username));
        }
        $encoder = $this->encoderFactory->getEncoder($user);
        if (!$user || !$encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())) {
            throw new \InvalidArgumentException('Invalid credentials');
        }

        return $user;
    }

    /**
     * @param array $parameters
     *
     * @return User
     */
    public function createUser($parameters)
    {
        /** @var User $user */
        $user = $this->userManager->createUser();
        $user->setUsername($parameters['username']);
        $user->setFirstName($parameters['first_name']);
        $user->setLastName($parameters['last_name']);
        $user->setEmail($parameters['email']);
        $user->setType(strtoupper($parameters['type']));
        $user->setPlainPassword($parameters['password']);
        $user->setEnabled(true);
        $this->userManager->updateUser($user);

        return $user;
    }
}