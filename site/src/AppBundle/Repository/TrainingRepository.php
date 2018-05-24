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
            ->setParameters($parameters);

        return $qb->getQuery()->getResult();
    }

}