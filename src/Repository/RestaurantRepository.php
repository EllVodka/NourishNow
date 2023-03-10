<?php

namespace App\Repository;

use App\Entity\Restaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Restaurant>
 *
 * @method Restaurant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restaurant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restaurant[]    findAll()
 * @method Restaurant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restaurant::class);
    }

    public function add(Restaurant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Restaurant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findRestaurant(int $idVille)
    {
        return $this->createQueryBuilder('r')
            ->addselect('tr')
            ->addselect('v')
            ->join('r.fk_typeResto', 'tr')
            ->join('r.fk_ville','v')
            ->where('v.id = :idVille')
            ->setParameter('idVille', $idVille)
            ->getQuery()
            ->getResult();
    }

    public function findRestaurantInSecteur(int $idSecteur)

    {
        return $this->createQueryBuilder('r')
        ->addSelect('v')
        ->addSelect('s')
        ->addSelect('e')
        ->join('r.fk_ville','v')
        ->join('v.fk_secteur', 's')
        ->leftJoin('r.evaluations','e')
        ->where('v.fk_secteur = :idSecteur')
        ->setParameter('idSecteur', $idSecteur)
        ->getQuery()
        ->getResult();
    }

//    /**
//     * @return Restaurant[] Returns an array of Restaurant objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Restaurant
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
