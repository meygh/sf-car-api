<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource]
#[ORM\Entity(repositoryClass: CarRepository::class)]
#[ApiFilter(RangeFilter::class, properties: ['reviews.starRating'])]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'The brand name could not leave blank')]
    #[Assert\Length(max: 50, maxMessage: 'The brand name must be less than {{ max }} characters to enter')]
    private ?string $brand = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'The model name could not leave blank')]
    #[Assert\Length(max: 100, maxMessage: 'The model name must be less than {{ max }} characters to enter')]
    private ?string $model = null;

    #[ORM\Column(length: 20)]
    #[Assert\Length(max: 20, maxMessage: 'The color name must be less than {{ max }} characters to enter')]
    private ?string $color = null;

    #[ORM\OneToMany(mappedBy: 'carId', targetEntity: Review::class, orphanRemoval: true)]
    private Collection $reviews;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $reviews): static
    {
        if (!$this->reviews->contains($reviews)) {
            $this->reviews->add($reviews);
            $reviews->setCarId($this);
        }

        return $this;
    }

    public function removeReview(Review $reviews): static
    {
        if ($this->reviews->removeElement($reviews)) {
            // set the owning side to null (unless already changed)
            if ($reviews->getCarId() === $this) {
                $reviews->setCarId(null);
            }
        }

        return $this;
    }
}
