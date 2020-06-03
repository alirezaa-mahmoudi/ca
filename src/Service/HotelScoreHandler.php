<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\HotelRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class HotelScoreHandler
{
    private HotelRepository $repository;
    private CacheInterface $cache;

    public function __construct(HotelRepository $repository, CacheInterface $cache)
    {
        $this->repository = $repository;
        $this->cache = $cache;
    }


    public function __invoke(string $uuid): ?array
    {
        $hotel = $this->repository->findOneBy(['uuid' => $uuid]);

        if (!$hotel) {
            throw new NotFoundHttpException();
        }

        $hotelId = $hotel->getId();

        return $this->cache->get('score'.$hotelId, function (ItemInterface $item) use ($hotelId) {
            $item->expiresAfter(3600);

            return $this->repository->calculateHotelScore($hotelId);
        });
    }
}
