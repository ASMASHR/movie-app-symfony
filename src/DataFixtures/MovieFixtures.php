<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $movie= new Movie();
        $movie->setTitle('The dark night');
        $movie->setDescription('this is the discripton of the The dark night movie');
        $movie->setReleaseYear(2008);
        $movie->setImagePath('https://cdn.pixabay.com/photo/2021/06/18/11/22/batman-6345897_960_720.jpg');
        $movie->addActor($this->getReference('actor_1'));
        $movie->addActor($this->getReference('actor_2'));
        $manager->persist($movie);

        $movie2= new Movie();
        $movie2->setTitle('Avengers: Endgame');
        $movie2->setDescription('this is the discripton of Avengers: Endgame ');
        $movie2->setReleaseYear(2019);
        $movie2->setImagePath('https://pixabay.com/photos/avenger-superhero-power-3382834/');
        $movie2->addActor($this->getReference('actor_3'));
        $movie2->addActor($this->getReference('actor_4'));
        $manager->persist($movie2);


        $movie3= new Movie();
        $movie3->setTitle('Batman');
        $movie3->setDescription('this is the discripton of batman');
        $movie3->setReleaseYear(2022);
        $movie3->setImagePath('https://pixabay.com/photos/batman-lego-egg-hatch-hatched-1367730/');
        $movie3->addActor($this->getReference('actor_1'));
        $movie3->addActor($this->getReference('actor_4'));
        $manager->persist($movie3); 

        $manager->flush();

    }
}
