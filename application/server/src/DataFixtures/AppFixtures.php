<?php

namespace App\DataFixtures;

use App\Factory\GroupFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        GroupFactory::createMany(5);
        UserFactory::createMany(50);

        $manager->flush();
    }
}
