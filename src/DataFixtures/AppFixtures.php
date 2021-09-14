<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $rand = rand(0, 1);
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPassword('$2y$13$K2rSzxzNr7JMlR/2UYC.xOijTnhTGsj/vRbxqhP2/M47iX0c4VYe6');
            $user->setName($faker->firstName);
            $user->setRoles($rand == 0 ? ['ROLE_GAMBLER'] : ['ROLE_CHALLENGER ']);
            $manager->persist($user);
        }

        $user = new User();
        $user->setEmail("admin@root.com");
        $user->setPassword('$2y$13$K2rSzxzNr7JMlR/2UYC.xOijTnhTGsj/vRbxqhP2/M47iX0c4VYe6');
        $user->setName('Admin');
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $manager->flush();
    }
}
