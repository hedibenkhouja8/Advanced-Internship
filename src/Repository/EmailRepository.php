<?php

namespace App\Repository;

use App\Entity\Email;
use App\Entity\EmailSearch;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Email|null find($id, $lockMode = null, $lockVersion = null)
 * @method Email|null findOneBy(array $criteria, array $orderBy = null)
 * @method Email[]    findAll()
 * @method Email[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Email::class);
    }

    /**
      * @return Email[] Returns an array of Email objects
      */
      public function findAllVisibleQuery(EmailSearch $search)
      {
          
  
          $qb = $this->createQueryBuilder('l');
          if($search->getemail()){
              $qb =$qb
                  ->andwhere('l.Email LIKE :email')
                  ->setParameter('email','%'.$search->getemail().'%');
  
          }
       
         
             $query=$qb->getQuery();
             return $query->execute();
                          
      }
  
    /**
      * @return Email[] Returns an array of Email objects
      */
      public function findNewReports()
      {
          return $this->createQueryBuilder('i')
             
              ->orderBy('i.CreatedAt', 'DESC')
              ->setMaxResults(4)
              ->getQuery()
              ->getResult()
          ;
      }
      


    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Email
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
