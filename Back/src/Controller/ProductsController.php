<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductsController extends AbstractController
{
    #[Route('/{products}')]
    public function index(ProductsRepository $repository, SerializerInterface $serializer)
    {
        $products = $repository->findAll();
        
        $context = [
            'groups' => ['product_list'],
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            },
            'enable_max_depth' => true,
        ];
        
        $json = $serializer->serialize($products, 'json', $context);
        
        return new JsonResponse($json, 200, [], true);
    }
}
