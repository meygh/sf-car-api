<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Car>
 *
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }
    
    /**
     * Get the latest reviews for a specific car with starRating >= 6.
     *
     * @param int $carId
     * @return array
     */
    public function getLatestReviewsForCar(int $carId): array
    {
        return $this->createQueryBuilder('c')
            ->select('c.id as carId, r.id as reviewId, r.starRating, r.reviewText') // Add any other fields you need
            ->leftJoin('c.reviews', 'r') // Assuming your relation is named "reviews"
            ->where('c.id = :carId')
            ->andWhere('r.starRating >= 6')
            ->orderBy('r.id', 'DESC') // Assuming you have a createdAt field in your Review entity
            ->setMaxResults(5) // Adjust the number of reviews to retrieve as needed
            ->setParameter('carId', $carId)
            ->getQuery()
            ->getResult();
    }
}
