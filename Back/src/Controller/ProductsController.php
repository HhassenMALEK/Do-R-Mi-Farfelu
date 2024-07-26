<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductsController extends AbstractController
{
    #[Route('/products', name: 'get_all_products')]
    public function index(ProductsRepository $repository, SerializerInterface $serializer)
    {
        $products = $repository->findAll();
        
        return $this->serializeProducts($products, $serializer);
    }

    #[Route('/products/category/{category}', name: 'get_products_by_category')]
    public function getByCategory(string $category, ProductsRepository $repository, SerializerInterface $serializer)
    {
        $products = $repository->findByCategory($category);
        
        if (empty($products)) {
            return new JsonResponse(['message' => 'Aucun produit trouvé dans cette catégorie'], 404);
        }
        
        return $this->serializeProducts($products, $serializer);
    }

    private function serializeProducts($products, SerializerInterface $serializer): JsonResponse
    {
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