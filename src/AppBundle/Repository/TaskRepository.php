<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TaskRepository extends EntityRepository
{
    public function count()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('COUNT(t)')
            ->from('AppBundle:Task', 't');

        return $qb->getQuery()->getSingleScalarResult();
    }
    public function getLastTask($user)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('t.itemId')
            ->from('AppBundle:Task', 't')
            ->where($qb->expr()->eq('t.userId', ':userId'))
            ->setParameter('userId', $user->getId())
            ->addOrderBy('t.itemId', 'desc')
            ->setMaxResults(1);

        return $qb->getQuery()->getSingleResult();
    }
}
