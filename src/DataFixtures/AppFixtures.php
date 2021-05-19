<?php

namespace App\DataFixtures;

use App\Entity\Serie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

       $generator = Faker\Factory::create('fr_FR');


        for($i=0; $i<=10; $i++){

            $serie = new Serie();

            $serie
                ->setBackdrop($generator->imageUrl())
                ->setName($generator->word())
                ->setGenre($generator->word())
                ->setFirstAirDate(new \datetime('-1 year'))
                ->setLastAirDate(new \datetime('-6 month'))
                ->setStatus('returning')
                ->setVote($generator->numberBetween(1,10))
                ->setPopularity($generator->randomFloat(2,0,100))
                ->setDateCreated(new \datetime)
                ->setPoster($generator->imageUrl())
                ->setTmdbId(123+$i);
            $manager->persist($serie);
        }

        $manager->flush();
    }
}
