<?php

namespace App\Repository;

use App\Entity\Licence;
use App\Entity\LicenceSearch;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Licence|null find($id, $lockMode = null, $lockVersion = null)
 * @method Licence|null findOneBy(array $criteria, array $orderBy = null)
 * @method Licence[]    findAll()
 * @method Licence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LicenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Licence::class);
    }

     /**
      * @return Licence[] Returns an array of Licence objects
    */
    public function findAllVisibleQuery(LicenceSearch $search)
    {
        
     //   $entityManager = $this->getEntityManager();
//$k = $entityManager->createQuery('SELECT count(transactions)  FROM App\Entity\Products ');

        $qb = $this->createQueryBuilder('l');
        if($search->getuser()){
            $qb =$qb
                ->andwhere('l.User LIKE :user')
                ->setParameter('user','%'.$search->getuser().'%');

        }
        if($search->getcompilancetype()){
            $qb =$qb
                ->andwhere('l.Compilance_type LIKE :compilancetype')
                ->setParameter('compilancetype',$search->getcompilancetype());

        }
       
           $query=$qb->getQuery();
           return $query->execute();
                        
    }

    
     /**
      * @return Licence[] Returns an array of Licence objects
    */
    public function findOldLicences()
    {
        return $this->createQueryBuilder('i')
           
            ->orderBy('i.expiration_date', 'ASC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;
    }
   
   
   
   
   
   
   
   
   
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Licence
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
