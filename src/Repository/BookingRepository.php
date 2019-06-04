<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Booking::class);
    }


    /**
     * @param $dateOfVisit
     * @return mixed
     * @throws NonUniqueResultException
     */
    public function countNbOfTicketsPerDay($dateOfVisit)
    {
        $qb = $this->createQueryBuilder('b');

        return $qb->select('sum(b.numberOfPeople)')
            ->andWhere('b.dateOfVisit = :dateOfVisit')
            ->setParameter('dateOfVisit', $dateOfVisit)
            ->getQuery()
            ->getSingleScalarResult();

    }

}
