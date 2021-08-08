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
        $faker = Faker\Factory::create('fr_FR');
for($i=0;$i<20;$i++){

    $inventory= new Inventory();
    $inventory->setEquipment($faker->word);
    $inventory->setUser($faker->randomElement($array = array ('Ali','Hedi','Oussema','Fathi')));
    $inventory->setLocaation($faker->randomElement($array = array ('IT department','Manegement Department','Administration Office','Warehouse')));
    $inventory->setNotes($faker->Text);
    $inventory->setOperatingSystem($faker->randomElement($array = array ('Windows','Linux','Redhat','Solid Works')));
    $inventory->setState($faker->randomElement($array = array ('Perfect','Good','bad')));
    $inventory->setBrand($faker->randomElement($array = array ('Asus','Dell','Samsung','Apple')));
    $inventory->setModel($faker->word);
   
    $inventory->setLastScan(new \DateTime);
    $inventory->setLastMaintenance(new \DateTime);
    $inventory->setSupplier($faker->name);
    $inventory->setPurchaseDate(new \DateTime);
    $inventory->setCreatedAt(new \DateTimeImmutable());
$manager->persist($inventory);}
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
