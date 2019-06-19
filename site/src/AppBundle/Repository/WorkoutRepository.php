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
            ->setMaxResults(Workout::NUMBER_WORKOUT_DASHBOARD)
            ->setParameters($parameters);

        $workouts = $qb->getQuery()->getResult();

        $parameters['workouts'] = $workouts;

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('workout', 'workout_exercises')
            ->from('AppBundle:Workout', 'workout')
            ->join('workout.workoutExercises', 'workout_exercises')
            ->where('workout.member = :member')
            ->andWhere('workout.id in (:workouts)')
            ->orderBy('workout.date', 'ASC')
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