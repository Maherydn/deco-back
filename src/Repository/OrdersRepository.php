<?php

namespace App\Repository;

use App\Entity\Orders;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Orders>
 */
class OrdersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Orders::class);
    }

    //    /**
    //     * @return Ordres[] Returns an array of Ordres objects
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

    //    public function findOneBySomeField($value): ?Ordres
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function getMonthlyTotalsByProduct(int $year, int $productId)
{
    $qb = $this->createQueryBuilder("t")
        ->select(
            "MONTH(t.createdAt) AS month",
            "COUNT(t.id) AS total_orders"
        )
        ->join("t.product", "p")
        ->where("YEAR(t.createdAt) = :year")
        ->andWhere("p.id = :productId")
        ->setParameter("year", $year)
        ->setParameter("productId", $productId)
        ->groupBy("month");

    return $qb->getQuery()->getResult();
}

}
