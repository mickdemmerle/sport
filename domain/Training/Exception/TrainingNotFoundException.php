<?php

namespace Sport\Domain\Training\Exception;

use Sport\Bundle\AppBundle\Entity\Member;

class TrainingNotFoundException extends \Exception
{
    public function __construct($trainingId, Member $member, $code = 0)
    {
        $message = sprintf('Training %s for user %s cannot be found.', $trainingId, $member->getId());

        parent::__construct($message, $code, null);
    }
}