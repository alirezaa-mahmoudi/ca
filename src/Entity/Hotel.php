<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HotelRepository")
 */
class Hotel
{
    /**
     * @ORM\Id()
     *
     * @ORM\GeneratedValue()
     *
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $address;

    /**
     * @ORM\Column(type="guid", nullable=true)
     */
    private string $uuid;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Chain", inversedBy="hotels")
     *
     * @ORM\JoinColumn(nullable=false)
     */
    private Chain $chain;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="hotel")
     */
    private $reviews;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4()->toString();
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getChain(): Chain
    {
        return $this->chain;
    }

    public function setChain(Chain $chain): self
    {
        $this->chain = $chain;

        return $this;
    }

    public function getReviews(): Collection
    {
        return $this->reviews;
    }
}
