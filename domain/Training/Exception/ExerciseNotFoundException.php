<?php

namespace Sport\Domain\Training\Exception;

use Sport\Bundle\AppBundle\Entity\Member;

class ExerciseNotFoundException extends \Exception
{
    public function __construct($exerciseId, Member $member, $code = 0)
    {
        $message = sprintf('Exercise %s for user %s cannot be found.', $exerciseId, $member->getId());

        parent::__construct($message, $code, null);
    }
}