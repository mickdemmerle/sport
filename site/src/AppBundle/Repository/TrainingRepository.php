<?php

namespace Sport\Bundle\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Sport\Bundle\AppBundle\Entity\Member;

class TrainingRepository extends EntityRepository
{
    /**
     * @param Member $member
     * @return array
     */
    public function findTrainingsByMember(Member $member)
    {
        $parameters = array(
            'member' => $member
        );

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('training')
            ->from('AppBundle:Training', 'training')
            ->where('training.member = :member')
            ->orderBy('training.createdOn', 'ASC')
            ->setParameters($parameters);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param int $id
     * @param Member $member
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findTraining($id, Member $member)
    {
        $parameters = array(
            'id' => $id,
            'member' => $member
        );

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('training')
            ->from('AppBundle:Training', 'training')
            ->where('training.member = :member')
            ->andWhere('training.id = :id')
            ->setParameters($parameters);

        return $qb->getQuery()->getOneOrNullResult();
    }

}