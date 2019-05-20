<?php

namespace App\DataFixtures;

use App\Entity\Manager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ManagerFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i = 0; $i<5; $i++) {
            for ($k = 0; $k<2; $k++) {
                $fn = $faker->firstName;
                $ln = $faker->lastName;

                $mng = new Manager();
                $mng
                    ->setDeptId($this->getReference('department-'.($i+1)))
                    ->setEmail(strtolower($fn.'.'.$ln.'@service.com'))
                    ->setFirstname($fn)
                    ->setLastname($ln);
                $manager->persist($mng);
            }
        }

        $manager->flush();
    }
}
