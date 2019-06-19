<?php

namespace Sport\Domain\Training\Exception;

use Sport\Bundle\AppBundle\Entity\Member;

class WorkoutNotFoundException extends \Exception
{
    public function __construct(Member $member, $code = 0)
    {
        $message = sprintf('Workout for user %s cannot be found.', $member->getId());

        parent::__construct($message, $code, null);
    }
}