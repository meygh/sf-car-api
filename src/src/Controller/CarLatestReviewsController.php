<?php

namespace App\Controller;

use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cars/{id}/latest-reviews', name: 'car_latest_reviews', methods: ['GET'])]
class CarLatestReviewsController extends AbstractController
{
    public function __construct(
        private readonly CarRepository $carRepository)
    {}
    
    public function __invoke(int $id): JsonResponse
    {
        $car = $this->carRepository->find($id);
        
        if (!$car) {
            throw new NotFoundHttpException('Car not found');
        }
        
        $latestReviews = $this->carRepository->getLatestReviewsForCar($id);
        
        $latestReviews = [
            'reviews' => $latestReviews
        ];
        
        return $this->json($latestReviews);
    }
}
