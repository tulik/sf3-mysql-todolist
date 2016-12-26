<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function count()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('COUNT(u)')
            ->from('AppBundle:User', 'u');

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getUserByName($username)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('u')
            ->from('AppBundle:User', 'u')
            ->where($qb->expr()->eq('u.username', ':username'))
            ->setParameter('username', $username);

        return $qb->getQuery()->getSingleResult();
    }
    public function getUserTasks($user)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('u, i')
            ->from('AppBundle:User', 'u')
            ->join('u.userTasks', 'i')
            ->where($qb->expr()->eq('u.id', ':userId'))
            ->setParameter('userId', $user->getId());

        return $qb->getQuery()->getOneOrNullResult();
    }
}