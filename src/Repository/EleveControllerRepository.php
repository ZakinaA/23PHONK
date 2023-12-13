<?php

namespace App\Repository;

use App\Entity\EleveController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EleveController>
 *
 * @method EleveController|null find($id, $lockMode = null, $lockVersion = null)
 * @method EleveController|null findOneBy(array $criteria, array $orderBy = null)
 * @method EleveController[]    findAll()
 * @method EleveController[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EleveControllerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EleveController::class);
    }

//    /**
//     * @return EleveController[] Returns an array of EleveController objects
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

//    public function findOneBySomeField($value): ?EleveController
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
