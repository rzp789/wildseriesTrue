<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use App\Entity\Program;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;


class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    const ACTORS = [
        'GEORGES CLOONEY',
        'ROCCO DI MERCI',
        'JOHN SANVOLTA',
        'PATRICK TOMSIT',
        'BERNARD LHERMITE',
        'SARAH CONOR',
        'PENELOPE DACRUZ'

    ];
    /*public function load(ObjectManager $manager)
    {
        foreach (self::ACTORS as $key => $actorName){
            $actor = new Actor();
            $actor->setName($actorName);

            $manager->persist($actor);
            $this->addReference('actor_' . $key, $actor);
            $actor->addProgram($this->getReference('program_1'));
        }
        $manager->flush();
    }*/
    public function load(ObjectManager $manager)
    {
        foreach (self::ACTORS as $key => $actorName){
            $actor = new Actor();
            $actor->setName($actorName);

            $manager->persist($actor);
            $this->addReference('actor_' . $key, $actor);
            $actor->addProgram($this->getReference('program_1'));
        }
        $faker = Faker\Factory::create();

        for ($i = 10; $i < 60; $i++) {
            $actor = new Actor();
            $actor->setName($faker->name);

            $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor);
            $actor->addProgram($this->getReference('program_5'));
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }

}