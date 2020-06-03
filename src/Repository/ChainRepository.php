<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Chain;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Chain|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chain|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chain[]    findAll()
 * @method Chain[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChainRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chain::class);
    }

    // /**
    //  * @return Chain[] Returns an array of Chain objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Chain
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function findHotelByChainId(int $id): ?array
    {
        $dql = '
        SELECT  h.name as hotel,h.address, h.uuid
        FROM App\Entity\Chain c INNER JOIN c.hotels h
        WHERE c.id = :id';

        $query = $this->getEntityManager()->createQuery($dql)->setParameter('id', $id);

        return $query->execute();
    }
}
