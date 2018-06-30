<?php

namespace Sport\Bundle\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Sport\Bundle\AppBundle\Entity\Member;
use Sport\Bundle\AppBundle\Entity\Workout;

class WorkoutRepository extends EntityRepository
{
    /**
     * @param Member $member
     * @return array
     */
    public function findNextWorkouts(Member $member)
    {
        $parameters = array(
            'member' => $member
        );

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('workout')
            ->from('AppBundle:Workout', 'workout')
            ->where('workout.member = :member')
            ->orderBy('workout.date', 'ASC')
            ->setMaxResults(Workout::NUMBER_WORKOUT_DASHBOARD)
            ->setParameters($parameters);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param Member $member
     * @return array
     */
    public function findWorkoutsByMember(Member $member)
    {
        $parameters = array(
            'member' => $member
        );

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('workout')
            ->from('AppBundle:Workout', 'workout')
            ->where('workout.member = :member')
            ->orderBy('workout.date', 'ASC')
            ->setParameters($parameters);

        return $qb->getQuery()->getResult();
    }
}