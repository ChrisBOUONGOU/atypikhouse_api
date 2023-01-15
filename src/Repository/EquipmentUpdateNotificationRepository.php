<?php

namespace App\Repository;

use App\Entity\EquipmentUpdateNotification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EquipmentUpdateNotification>
 *
 * @method EquipmentUpdateNotification|null find($id, $lockMode = null, $lockVersion = null)
 * @method EquipmentUpdateNotification|null findOneBy(array $criteria, array $orderBy = null)
 * @method EquipmentUpdateNotification[]    findAll()
 * @method EquipmentUpdateNotification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipmentUpdateNotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EquipmentUpdateNotification::class);
    }

    public function save(EquipmentUpdateNotification $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EquipmentUpdateNotification $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return EquipmentUpdateNotification[] Returns an array of EquipmentUpdateNotification objects
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

//    public function findOneBySomeField($value): ?EquipmentUpdateNotification
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
