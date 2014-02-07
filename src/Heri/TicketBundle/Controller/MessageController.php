<?php

/**
 * This file is part of HeriTicketBundle.
 *
 * @author Alexandre Mogère
 */

namespace Heri\TicketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Heri\TicketBundle\Model\MessageQuery;

class MessageController extends Controller
{
    /**
     * @Route("/message/list", name="_message_list")
     */
    public function listAction()
    {
        $listMessages = array();
        $total = 0;
        $success = true;
        $error = "";
        
        $request = $this->get('request');
        try {
            $messages = MessageQuery::create()->paginateGrid($request->query);
            
            foreach ($messages as $message) {
                $listMessages[] = array_merge(
                    $message->toArray(),
                    array(
                        'Priority' => (string) $message->getPriority()
                    )
                );
            }
            
            $total = $messages->getNbResults();
        } catch (\Exception $e) {
            $success = false;
            $error = $e->getMessage();
        }
        
        $response = new Response(json_encode(array(
            'success'    => (bool) $success,
            'totalCount' => (int) $total,
            'results'    => $listMessages,
            'error'      => $error
        )));
        
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
    
    protected function prepareRow($row)
    {
        return $row;
    }

}