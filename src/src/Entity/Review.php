<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\ReviewsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(description: 'Retrieves the collection of Car reviews sorted ascending.', order: ['id' => 'ASC'])]
#[ApiResource(operations: [
    new GetCollection(),
    new GetCollection(
        uriTemplate: 'latest-reviews',
        order: ['id' => 'DESC'],
        description: 'Retrieves the collection of Car reviews sorted descending.',
        name: 'latest_reviews'
    )
])]
#[ORM\Entity(repositoryClass: ReviewsRepository::class)]
#[ApiFilter(RangeFilter::class, properties: ['starRating'])]
#[ApiFilter(SearchFilter::class, properties: [
    'id' => 'exact',
    'carId' => 'exact',
    'reviewText' => 'partial'
])]
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
    #[Assert\NotBlank(message: 'The starRating property could not leave blank')]
    #[Assert\Range(
        notInRangeMessage: 'Star Rating must be between {{ min }} and {{ max }} number to enter',
        min: 1,
        max: 10
    )]
    private ?int $starRating = 1;
    
    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'Your feedback must be less than {{ max }} characters to enter')]
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
