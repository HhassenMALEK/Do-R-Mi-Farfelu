<?php

namespace App\Repository;

use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Products>
 */
class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Products::class);
    }

    public function findAll(): array
    {
    return $this->createQueryBuilder('p')
    ->select('p','i','c')
    ->leftJoin('p.pictures', 'i')
    ->leftJoin('p.categories', 'c')
    ->getQuery()
    ->getResult();
    }

    public function findByCategory(string $category): array
    {
    return $this->createQueryBuilder('p')
        ->select('p', 'i', 'c')
        ->leftJoin('p.pictures', 'i')
        ->leftJoin('p.categories', 'c')
        ->andWhere('c.name = :category')
        ->setParameter('category', $category)
        ->getQuery()
        ->getResult();
    }
    
   
}
