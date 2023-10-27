<?php

namespace App\Repository;

use App\Entity\Oeuvrelink;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Oeuvrelink>
 *
 * @method Oeuvrelink|null find($id, $lockMode = null, $lockVersion = null)
 * @method Oeuvrelink|null findOneBy(array $criteria, array $orderBy = null)
 * @method Oeuvrelink[]    findAll()
 * @method Oeuvrelink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OeuvrelinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Oeuvrelink::class);
    }

//    /**
//     * @return Oeuvrelink[] Returns an array of Oeuvrelink objects
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

//    public function findOneBySomeField($value): ?Oeuvrelink
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
