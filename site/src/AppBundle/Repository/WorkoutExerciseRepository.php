<?php

namespace Sport\Bundle\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Sport\Bundle\AppBundle\Entity\Member;
use Sport\Bundle\AppBundle\Entity\Workout;

class WorkoutExerciseRepository extends EntityRepository
{
    /**
     * @param Workout $workout
     * @param Member $member
     * @return array
     */
    public function findWorkoutExercisesByMember(Workout $workout, Member $member)
    {
        $parameters = array(
            'workout' => $workout,
            'member' => $member
        );

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('workout_exercise')
            ->from('AppBundle:WorkoutExercise', 'workout_exercise')
            ->where('workout_exercise.member = :member')
            ->andWhere('workout_exercise.workout = :workout')
            ->setParameters($parameters);

        return $qb->getQuery()->getResult();
    }
}