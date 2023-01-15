<?php

namespace App\Repository;

use App\Entity\ExceptionalUnavailability;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExceptionalUnavailability>
 *
 * @method ExceptionalUnavailability|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExceptionalUnavailability|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExceptionalUnavailability[]    findAll()
 * @method ExceptionalUnavailability[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExceptionalUnavailabilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExceptionalUnavailability::class);
    }

    public function save(ExceptionalUnavailability $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ExceptionalUnavailability $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ExceptionalUnavailability[] Returns an array of ExceptionalUnavailability objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ExceptionalUnavailability
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
