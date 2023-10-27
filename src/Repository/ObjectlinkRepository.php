<?php

namespace App\Repository;

use App\Entity\Objectlink;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Objectlink>
 *
 * @method Objectlink|null find($id, $lockMode = null, $lockVersion = null)
 * @method Objectlink|null findOneBy(array $criteria, array $orderBy = null)
 * @method Objectlink[]    findAll()
 * @method Objectlink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjectlinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Objectlink::class);
    }

//    /**
//     * @return Objectlink[] Returns an array of Objectlink objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Objectlink
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
