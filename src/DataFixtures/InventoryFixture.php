<?php

namespace App\DataFixtures;
//use vendor\fzaninotto\faker\src\Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Inventory;
use Faker;
class InventoryFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
for($i=0;$i<10;$i++){

    $inventory= new Inventory();
    $inventory->setEquipment($faker->word);
    $inventory->setUser($faker->word);
    $inventory->setLocaation($faker->word);
    $inventory->setNotes($faker->word);
    $inventory->setOperatingSystem($faker->word);
    $inventory->setState($faker->word);
    $inventory->setBrand($faker->word);
    $inventory->setModel($faker->word);
   
    $inventory->setLastScan($faker->date($format = 'Y-m-d', $max = 'now'));
    $inventory->setLastMaintenance($faker->date($format = 'Y-m-d', $max = 'now'));
    $inventory->setSupplier($faker->word);
    $inventory->setPurchaseDate($faker->date($format = 'Y-m-d', $max = 'now'));
    $inventory->setCreatedAt(new \DateTimeImmutable());
$manager->persist($inventory);}
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
