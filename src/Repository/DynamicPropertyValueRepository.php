<?php

namespace App\Repository;

use App\Entity\DynamicPropertyValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DynamicPropertyValue>
 *
 * @method DynamicPropertyValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method DynamicPropertyValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method DynamicPropertyValue[]    findAll()
 * @method DynamicPropertyValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DynamicPropertyValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DynamicPropertyValue::class);
    }

    public function save(DynamicPropertyValue $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DynamicPropertyValue $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DynamicPropertyValue[] Returns an array of DynamicPropertyValue objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DynamicPropertyValue
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
