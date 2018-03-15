<?php

namespace AppBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends Fixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var UserManager
     */
    protected $userManager;

    public function load(ObjectManager $manager)
    {
        $lorem = 'Lorem ipsum dolor amet consectetur adipiscing elit sed eiusmod tempor incididunt labore dolore magna aliqua enim ad minim veniam quis nostrud exercitation ullamco laboris nisi aliquip ex ea commodo consequat';
        $nameList = explode(' ', $lorem);

        for ($i = 0; $i < 3; $i ++) {
            $username = $nameList[array_rand($nameList)];
            /** @var User $user */
            $user = $this->userManager->createUser();
            $user->setFirstName('John');
            $user->setLastName('Doe');
            $user->setUsername($username);
            $user->setEmail($username.'@gmail.com');
            $user->setPlainPassword('admin');
            $user->setEnabled(true);
            $user->setRoles(array('ROLE_ADMIN'));

            $this->userManager->updateUser($user, true);
            $this->setReference('user'.$i, $user);
        }
    }

    /**
     * @param ContainerInterface|null $container Container
     *
     * @return null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->userManager = $container->get('fos_user.user_manager');
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}