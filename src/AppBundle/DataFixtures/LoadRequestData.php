<?php
/**
 * LoadRequestData class file
 *
 * PHP Version 7.1
 *
 * @category Fixture
 * @package  AppBundle\DataFixtures
 */
namespace AppBundle\DataFixtures;

use AppBundle\Entity\Request;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

/**
 * Class LoadRequestData
 * @package AppBundle\DataFixtures
 */
class LoadRequestData extends Fixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $lorem = 'Lorem ipsum dolor amet consectetur adipiscing elit sed eiusmod tempor incididunt labore dolore magna aliqua enim ad minim veniam quis nostrud exercitation ullamco laboris nisi aliquip ex ea commodo consequat';
        $nameList = explode(' ', $lorem);

        for ($i = 0; $i < 3; $i ++) {
            /** @var User $user */
            $user = $this->getReference('user0');
            $title = $nameList[array_rand($nameList)];

            $request = new Request();
            $request->setTitle($title);
            $request->setText('Lorem ipsum dolor amet consectetur adipiscing');
            $request->setAngle(rand(30, 170));
            $request->setUser($user);

            $manager->persist($request);
            $manager->flush();
        }
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 3;
    }
}