<?php

namespace App\Repository;

use App\Entity\Product;

use App\Entity\PropertySearch;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }
  
 
    /**
     * @return Product[]
     */
    public function findAllVisibleQuery(PropertySearch $search)
    {
        
     //   $entityManager = $this->getEntityManager();
//$k = $entityManager->createQuery('SELECT count(transactions)  FROM App\Entity\Products ');

        $qb = $this->createQueryBuilder('p');
        if($search->getminQuantity()){
            $qb =$qb
                ->andwhere('p.quantity >= :minQuantity')
                ->setParameter('minQuantity',$search->getminQuantity());

        }
        if($search->getmanufacturer()){
            $qb =$qb
                ->andwhere('p.manufacturer LIKE :manufacturer')
                ->setParameter('manufacturer',$search->getmanufacturer());

        }
        if($search->getstockingarea()){
            $qb =$qb
                ->andwhere('p.stocking_area LIKE :stockingarea')
                ->setParameter('stockingarea',$search->getstockingarea());

        }
           $query=$qb->getQuery();
           return $query->execute();
                        
    }
    /**
     * @return Product[] Returns an array of Product objects
     */
       
    public function findLowQuality()
    {
        return $this->createQueryBuilder('i')
           
            ->orderBy('i.quantity', 'ASC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;
    }
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
