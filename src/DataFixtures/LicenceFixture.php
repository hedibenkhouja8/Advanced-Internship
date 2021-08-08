<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Licence;

use App\Entity\Category;
use Faker;
class LicenceFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
            $faker = Faker\Factory::create('fr_FR');
            for($j=0;$j<5;$j++){
        
                $category= new Category();
                $category->setname($faker->word);
                $category->setdescription($faker->text);
                $manager->persist($category);
                //mt_rand(5,6);
        for($i=0;$i<10;$i++){
        
            $licence= new Licence();
            $licence->setProductName($faker->word);
            $licence->setSupplier($faker->name);
            $licence->setType($faker->randomElement($array = array ('OS','Software')));
            $licence->setCompilanceType($faker->randomElement($array = array ('Normal','Pro')));
            $licence->setUser($faker->randomElement($array = array ('Mohamed','Ahmed','Sarah')));
          
           
            $licence->setPurchaseDate(new \DateTime());
            $licence->setExpirationDate(new \DateTime());
            $licence->setCategory($category);
            $licence->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($licence);
        } 
    }
        
                $manager->flush();
    }
}
