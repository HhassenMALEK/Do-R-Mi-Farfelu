<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoriesRepository; 
use App\Repository\PicturesRepository; 

class ProductsController extends AbstractController
{
    #[Route('/{products}')]
    public function index(ProductsRepository $repository)
    {
        $products = $repository->findAll();
        //dd($products);
        return $this->json($products, 200, [], [
            'groups' => ['products.index']
        ]);
    }
    
    #[Route('/products/{category}')]
    public function category(ProductsRepository $repository, string $category)
    {
        $instrtument = $repository->findBy(['categories' => $category]);
        dd($instrtument);
        return $this->json($instrtument, 200, [], [
            'groups' => ['products.categories']
        ]);
        // #[Route('/api/supply/{category}')]
        // public function category(MeubleEcoRepository $repository, string $category) //ici on ne traite que l'information category
        // {
        //     $furniture = $repository->findBy(['category' => $category]);
        //     //dd($furniture); //var_dump $furniture
        //     return $this -> json($furniture, 200, [], [
        //         'groups' => ['supply.category']
        //     ]);
        // }
    }
}
