<?php

namespace App\DataFixtures;

use App\Entity\ClickRewardRate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClickRewardRateFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $rate1 = new ClickRewardRate();
        $rate1->setFrom(new \DateTime('22:00:00'));
        $rate1->setTo(new \DateTime('06:00:00'));
        $rate1->setRate(0.01);
        $rate1->setCurrency('USD');
        $manager->persist($rate1);

        $rate2 = new ClickRewardRate();
        $rate2->setFrom(new \DateTime('06:00:00'));
        $rate2->setTo(new \DateTime('22:00:00'));
        $rate2->setRate(0.005);
        $rate2->setCurrency('EUR');
        $manager->persist($rate2);

        $manager->flush();
    }
}
