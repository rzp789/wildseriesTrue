<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{


    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 6; $i++) {
            $season = new Season();
            $season->setYear($faker->year);
            $season->setDescription($faker->text);
            $manager->persist($season);
            $season->setProgram($this->getReference('program_' . $i));
            $this->addReference('season_' . $i, $season);


            $manager->flush();
        }
    }
    public function getDependencies()
    {

        return [ProgramFixtures::class];

    }
}