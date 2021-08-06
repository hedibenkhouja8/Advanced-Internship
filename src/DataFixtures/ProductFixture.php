<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;
use App\Entity\Transaction;
use Faker;
class ProductFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
for($i=0;$i<20;$i++){

    $product= new Product();
    $product->setreference($faker->word);
    $product->setdescription($faker->text);
    $product->setmanufacturer($faker->word);
    $product->setquantity($faker->randomDigit);
    $product->setstockingArea($faker->word);
    
    $product->setCreatedAt(new \DateTimeImmutable());
    $manager->persist($product);
//transactions for each product
    for($j=0;$j<5;$j++){

        $transaction= new Transaction();
        $transaction->setnote($faker->text);
        $transaction->setquantity($faker->randomDigit);
        $transaction->settype("Output");
    
        $transaction->setTransactionDate(new \DateTime());
        $transaction->setproduct($product);
        $transaction->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($transaction);
    
    
    
    
    
    }



}

        $manager->flush();
    }
}
