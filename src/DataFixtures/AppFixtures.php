<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Chain;
use App\Entity\Hotel;
use App\Entity\Review;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $this->loadChain($manager);
        $this->loadHotels($manager);
        $this->loadReviews($manager);

        $manager->flush();
    }

    public function loadHotels($manager)
    {
        $hotel = new Hotel();
        $hotel->setId(1);
        $hotel->setName('Hotel Alexanderplatz');
        $hotel->setAddress('Alexanderplatz 1, 10409, Berlin');
        $hotel->setUuid('31d0a02d-ec54-46dd-b264-350591e3429b');
        $hotel->setChain($this->getReference('chain_1'));
        $this->setReference('hotel_1', $hotel);

        $manager->persist($hotel);

        $hotel = new Hotel();
        $hotel->setId(2);
        $hotel->setName('Hotel Alexanderplatz');
        $hotel->setAddress('Alexanderplatz 1, 10409, Berlin');
        $hotel->setUuid('811cdddb-9acc-4652-93ce-2bdc25d46028');
        $hotel->setChain($this->getReference('chain_1'));
        $this->setReference('hotel_2', $hotel);

        $manager->persist($hotel);

        $hotel = new Hotel();
        $hotel->setId(3);
        $hotel->setName('Hotel Alexanderplatz');
        $hotel->setAddress('Alexanderplatz 1, 10409, Berlin');
        $hotel->setUuid('52806224-32bf-4ce7-ab6c-178cf57a544a');
        $hotel->setChain($this->getReference('chain_1'));

        $manager->persist($hotel);

        $hotel = new Hotel();
        $hotel->setId(4);
        $hotel->setName('Hotel Alexanderplatz');
        $hotel->setAddress('Alexanderplatz 1, 10409, Berlin');
        $hotel->setUuid('e95cdd04-4cf8-4303-9630-539cddf8739f');
        $hotel->setChain($this->getReference('chain_1'));

        $manager->persist($hotel);

        $hotel = new Hotel();
        $hotel->setId(5);
        $hotel->setName('Hotel Alexanderplatz');
        $hotel->setAddress('Alexanderplatz 1, 10409, Berlin');
        $hotel->setUuid('7eb96246-5231-4ca5-887a-13b2a5e467b2');
        $hotel->setChain($this->getReference('chain_1'));

        $manager->persist($hotel);
    }

    public function loadReviews($manager)
    {
        // hotel 1
        $review = new Review();
//        $review->setHotelId(1);
        $review->setComment('Very nice stay');
        $review->setScore(10);
        $review->setHotel($this->getReference('hotel_1'));
        $manager->persist($review);

        $review = new Review();
//        $review->setHotelId(1);
        $review->setComment('Average');
        $review->setScore(5);
        $review->setHotel($this->getReference('hotel_1'));
        $manager->persist($review);

        $review = new Review();
//        $review->setHotelId(1);
        $review->setComment('Very nice stay, I enjoyed it a lot.');
        $review->setScore(9);
        $manager->persist($review);
        $review->setHotel($this->getReference('hotel_1'));

        $review = new Review();
//        $review->setHotelId(1);
        $review->setComment('Worst experience ever.');
        $review->setScore(1);
        $manager->persist($review);
        $review->setHotel($this->getReference('hotel_1'));

        // hotel 2
        $review = new Review();
//        $review->setHotelId(2);
        $review->setComment('The receptionist was not smiling.');
        $review->setScore(5);
        $manager->persist($review);
        $review->setHotel($this->getReference('hotel_2'));

        $review = new Review();
//        $review->setHotelId(2);
        $review->setComment('Very nice stay, the reception was really fast.');
        $review->setScore(10);
        $manager->persist($review);
        $review->setHotel($this->getReference('hotel_2'));
    }

    public function loadChain($manager)
    {
        // chain 1
        $chain = new Chain();
        $chain->setId(1);
        $chain->setName('Hilton');
        $this->setReference('chain_1', $chain);
        $manager->persist($chain);

        //chain 2
        $chain = new Chain();
        $chain->setId(2);
        $chain->setName('ibis');
        $this->setReference('chain_2', $chain);
        $manager->persist($chain);
    }
}
