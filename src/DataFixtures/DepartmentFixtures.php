<?php

namespace App\DataFixtures;

use App\Entity\Department;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DepartmentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $departments = ['Direction', 'Ressources Humaines', 'Communication', 'Développement', 'Logistique'];

        for ($i = 0, $dptLenght = count($departments); $i<$dptLenght; $i++) {
            $dpt = new Department();
            $dpt->setDepartment($departments[$i]);
            $manager->persist($dpt);
            $this->addReference('department-'.($i+1), $dpt);
        }
        $manager->flush();
    }
}
