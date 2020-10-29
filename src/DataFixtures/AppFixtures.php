<?php

namespace App\DataFixtures;

use App\Entity\Hero;
use App\Entity\Power;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $powers = [];
        for ($i=0; $i < 5; $i++) { 
            $power = new Power();
            $power->setName('power '.$i)->setType('type '.$i);
            $manager->persist($power);
            $powers[] = $power;
        }

        for ($i=0; $i < 5 ; $i++) { 
            $hero = new Hero();
            $hero->setName($faker->name)
            ->setLevel($faker->randomNumber())
            ->setBirthdate($faker->dateTime())
            ->setTitle('The Great ' . $faker->firstName);
            for ($y=0; $y < 2; $y++) { 
                $hero->addPower($powers[random_int(0, 4)]);
            }
            $manager->persist($hero);
        }


        $user = new User();
        $user->setEmail('bidon@mail.com')
        ->setRoles(['ROLE_USER'])
        ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$wnQgeIeNxRT6lYp24EIdEQ$/rFoA3ozyzmW+j75Sp+fF3MR41+JFWjNaxKb44y3R4o'); //password is 1234

        $manager->persist($user);
        
        $manager->flush();
    }

    
}
