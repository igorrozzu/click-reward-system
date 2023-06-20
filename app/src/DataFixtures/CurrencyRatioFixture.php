<?php

namespace App\DataFixtures;

use App\Entity\CurrencyRatio;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CurrencyRatioFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $ratio1 = new CurrencyRatio('USD', 'USD', 1);
        $manager->persist($ratio1);

        $ratio2 = new CurrencyRatio('USD', 'EUR', 0.93);
        $manager->persist($ratio2);

        $ratio3 = new CurrencyRatio('USD', 'GBP', 0.81);
        $manager->persist($ratio3);

        $manager->flush();
    }
}
