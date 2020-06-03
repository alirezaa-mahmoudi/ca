<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Hotel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException as NonUniqueResultExceptionAlias;

/**
 * @method Hotel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hotel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hotel[]    findAll()
 * @method Hotel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HotelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hotel::class);
    }

    /**
     * @param string $uuid
     * @return array|null
     */
    public function findAllHotelReviewsByUuid(string $uuid): ?array
    {
        $dql = '
        SELECT r.id, h.uuid,r.score, r.comment 
        FROM App\Entity\Hotel h INNER JOIN h.reviews r
        WHERE h.uuid = :uuid';

        $query = $this->getEntityManager()->createQuery($dql)->setParameter('uuid', $uuid);

        return $query->execute();
    }

    /**
     * @param int $hotelId
     * @return array|null
     * @throws NonUniqueResultExceptionAlias
     */
    public function calculateHotelScore(int $hotelId): ?array
    {
        $dql = '
        SELECT AVG(r.score) AS score
        FROM App\Entity\Review r 
        WHERE r.hotel = :hotelId';

        $query = $this->getEntityManager()->createQuery($dql)->setParameter('hotelId', $hotelId);

        return $query->getOneOrNullResult();
    }
}
