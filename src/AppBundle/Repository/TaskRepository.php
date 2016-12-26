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
}