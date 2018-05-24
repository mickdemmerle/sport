<?php

namespace Sport\Bundle\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Sport\Bundle\AppBundle\Entity\Member;

class ExerciseRepository extends EntityRepository
{
    /**
     * @param int $id
     * @param Member $member
     *
     * @return mixed
     *
     * @throws NonUniqueResultException
     */
    public function findExercise($id, Member $member)
    {
        $parameters = array(
            'id' => $id,
            'member' => $member
        );

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('exercise')
            ->from('AppBundle:Exercise', 'exercise')
            ->where('exercise.member = :member')
            ->andWhere('exercise.id = :id')
            ->setParameters($parameters);

        return $qb->getQuery()->getOneOrNullResult();
    }
}