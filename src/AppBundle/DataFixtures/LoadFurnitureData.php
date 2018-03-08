<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Furniture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadFurnitureData extends Fixture implements OrderedFixtureInterface
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

            $furniture = new Furniture();
            $furniture->setTitle($title);
            $furniture->setWidth(rand(10, 100));
            $furniture->setHeight(rand(10, 100));
            $furniture->setDepth(rand(10, 100));
            $furniture->setUser($user);

            $manager->persist($furniture);
            $manager->flush();
        }
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }
}