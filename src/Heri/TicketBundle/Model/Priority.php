<?php

namespace Heri\TicketBundle\Model;

use Heri\TicketBundle\Model\om\BasePriority;

class Priority extends BasePriority
{
    public function __toString() {
        return $this->getLabel();
    }
}
