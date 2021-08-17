<?php

namespace App\Repository;

use App\Entity\Inventory;
use App\Entity\InventorySearch;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Inventory|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inventory|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inventory[]    findAll()
 * @method Inventory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InventoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inventory::class);
    }

 /**
     * @return Inventory[] Returns an array of Inventory objects
     */

    public function findAllVisibleQuery(InventorySearch $search)
    {
        

        $qb = $this->createQueryBuilder('l');
        if($search->getlocation()){
            $qb =$qb
                ->andwhere('l.Locaation LIKE :location')
                ->setParameter('location','%'.$search->getlocation().'%');

        }
        if($search->getoperatingsystem()){
            $qb =$qb
                ->andwhere('l.OperatingSystem LIKE :operatingsystem')
                ->setParameter('operatingsystem',$search->getoperatingsystem());

        }
        if($search->getstate()){
            $qb =$qb
                ->andwhere('l.State LIKE :state')
                ->setParameter('state',$search->getstate());

        }
        if($search->getbrand()){
            $qb =$qb
                ->andwhere('l.Brand LIKE :brand')
                ->setParameter('brand',$search->getbrand());

        }
           $query=$qb->getQuery();
           return $query->execute();
                        
    }

 /**
     * @return Inventory[] Returns an array of Inventory objects
     */
    
    public function findOldItems()
    {
        return $this->createQueryBuilder('i')
           
            ->orderBy('i.LastScan', 'ASC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Inventory
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
