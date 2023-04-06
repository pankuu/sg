<?php

namespace App\Repository;

use App\Entity\AccidentNotification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AccidentNotification>
 *
 * @method AccidentNotification|null find($id, $lockMode = null, $lockVersion = null)
 * @method AccidentNotification|null findOneBy(array $criteria, array $orderBy = null)
 * @method AccidentNotification[]    findAll()
 * @method AccidentNotification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccidentNotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccidentNotification::class);
    }

    public function save(AccidentNotification $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AccidentNotification $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AccidentNotificationCreator[] Returns an array of AccidentNotificationCreator objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AccidentNotificationCreator
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
