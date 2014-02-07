<?php

/*
 * This file is part of HeriTicketBundle.
 *
 * @author Alexandre Mogre
 */

namespace Heri\TicketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

class ViewportController extends Controller
{
    /**
     * @Route("/", name="_viewport")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}
