<?php

namespace App\Repository;

use App\Entity\ContactSubject;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<ContactSubject>
 *
 * @method ContactSubject|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactSubject|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactSubject[]    findAll()
 * @method ContactSubject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactSubjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactSubject::class);
    }

    public function save(ContactSubject $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ContactSubject $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
