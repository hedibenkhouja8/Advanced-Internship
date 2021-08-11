<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use App\Entity\Product;
use App\Entity\Transaction;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProductFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
for($i=0;$i<20;$i++){

    $product= new Product();
    $product->setreference($faker->word);
    $product->setdescription($faker->text);
    $product->setmanufacturer($faker->randomElement($array = array ('Mechanic Depatrtment','Chemics Department','IT department ')));
    $product->setquantity($faker->numberBetween($min = 50, $max = 9000));
    $product->setstockingArea($faker->randomElement($array = array ('Main Warehouse','Backyard Warehouse','IT department Warehouse')));
    
    $product->setCreatedAt(new \DateTimeImmutable());
    $manager->persist($product);
//transactions for each product
for($c=0;$c<2;$c++){
    $user =new User();
    $user->setUsername($faker->word);
    $user->setEmail($faker->email);
    $user->setPassword($faker->password);

    $manager->persist($user);
    for($j=0;$j<5;$j++){

        $transaction= new Transaction();
        $transaction->setnote($faker->text);
        $transaction->setquantity($faker->randomDigit);
        $transaction->setUser($user);
        $transaction->settype($faker->randomElement($array = array ('Output','Input')));
    
        $transaction->setTransactionDate(new \DateTime());
        $transaction->setproduct($product);
       
        $transaction->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($transaction);
    }
    
    
}
    
    



}

        $manager->flush();
    }
}
