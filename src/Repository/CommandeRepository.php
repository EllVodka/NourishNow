<?php

namespace App\Repository;

use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commande>
 *
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    public function add(Commande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Commande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findCommandeByRestoId(int $restoId)
    {
        return $this->createQueryBuilder('c')
            ->addselect('p')
            ->addselect('c')
            ->addSelect('dc')
            ->addSelect('s')
            ->addSelect('r')
            ->join('c.detailCommandes', 'dc')
            ->join('c.fk_status', 's')
            ->join('dc.fk_plat', 'p')
            ->join('p.fk_restaurant', 'r')
            ->where('r.id = :idResto')
            ->orderBy('c.date ', 'DESC')
            ->setParameter('idResto', $restoId)
            ->getQuery()
            ->getResult();
    }

    public function findCommande(int $id)
    {
        return $this->createQueryBuilder('c')
            ->addselect('p')
            ->addselect('dc')
            ->addSelect('s')
            ->addSelect('r')
            ->join('c.detailCommandes', 'dc')
            ->join('c.fk_status', 's')
            ->join('dc.fk_plat', 'p')
            ->join('p.fk_restaurant', 'r')
            ->where('c.id = :id')
            ->orderBy('c.date ', 'DESC')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    public function findCommandByStatusAndDateInSecteur(int $idSecteur): array
    {
        return $this->createQueryBuilder('c')
            ->addSelect('p')
            ->addSelect('dc')
            ->addSelect('s')
            ->addSelect('r')
            ->addSelect('v')
            ->addSelect('sec')
            ->join('c.detailCommandes', 'dc')
            ->join('c.fk_status', 's')
            ->join('dc.fk_plat', 'p')
            ->join('p.fk_restaurant', 'r')
            ->join('r.fk_ville', 'v')
            ->join('v.fk_secteur', 'sec')
            ->where('DAY(c.date) = DAY(NOW())')
            ->andWhere('c.fk_status = 3')
            ->andWhere('sec.id = :idSecteur')
            ->setParameter('idSecteur', $idSecteur)
            ->getQuery()
            ->getResult();
    }

    public function findAllCommandByClientId(int $id)
    {
        return $this->createQueryBuilder('c')
            ->addSelect('cl')
            ->addSelect('dc')
            ->addSelect('p')
            ->addSelect('r')
            ->addSelect('v')
            ->join('c.fk_client', 'cl')
            ->join('c.detailCommandes', 'dc')
            ->join('dc.fk_plat', 'p')
            ->join('p.fk_restaurant', 'r')
            ->join('r.fk_ville', 'v')
            ->where('cl.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
    //    /**
    //     * @return Commande[] Returns an array of Commande objects
    //     */

    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Commande
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
