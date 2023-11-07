<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ReviewsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Range;

#[ORM\Entity(repositoryClass: ReviewsRepository::class)]
#[ApiResource]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'starRating')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Car $carId = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Range(min: 1, max: 10, notInRangeMessage: 'Star Rating must be between {{ min }} and {{ max }} number to enter')]
    private ?int $starRating = 1;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reviewText = null;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarId(): ?Car
    {
        return $this->carId;
    }

    public function setCarId(?Car $carId): static
    {
        $this->carId = $carId;

        return $this;
    }

    public function getStarRating(): ?int
    {
        return $this->starRating;
    }

    public function setStarRating(int $starRating): static
    {
        $this->starRating = $starRating;

        return $this;
    }

    public function getReviewText(): ?string
    {
        return $this->reviewText;
    }

    public function setReviewText(?string $reviewText): static
    {
        $this->reviewText = $reviewText;

        return $this;
    }
}
