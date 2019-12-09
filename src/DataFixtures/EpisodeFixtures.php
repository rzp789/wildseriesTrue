<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{


    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 6; $i++) {
            $episode = new Episode();
            $episode->setTitle($faker->text);
            $episode->setSynopsis($faker->text);
            $manager->persist($episode);
            $episode->setSeason($this->getReference('season_' . $i));

        }
            $manager->flush();

    }
    public function getDependencies()
    {

        return [SeasonFixtures::class];

    }
}