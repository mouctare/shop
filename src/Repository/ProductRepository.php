<?php

namespace App\Repository;

use App\Classes\Search;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

 /**
 
 * Requete qui me permet de faire de recherche selon l'inpu des clients
  * return Product[]
  * 
  */
    public function findWithSearch(Search $search)
    { 
     $query = $this->createQueryBuilder('p') // Ici je cherche dans la table Product Alias p
      // J'ai besoin qui tu me selectionnes c, pour categorie
                  ->select('c', 'p')
                  ->join('p.category', 'c');
                  if(!empty($search->categories)) {
                      // Je veut que si $cherach n'est pas vide, tu reprennes ma query et tu rajoute ma recherche
                      $query = $query
                      ->andWhere('c.id IN (:categories)')
                      ->setParameter('categories', $search->categories);
                  }
                  if(!empty($search->name)){
                      $query = $query
                         ->andWhere('p.name LIKE :name')
                         ->setParameter('name', "%($search->name)%");
                  }
                  return $query->getQuery()->getResult();
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
