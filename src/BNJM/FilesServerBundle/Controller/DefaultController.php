<?php

namespace BNJM\FilesServerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation as HF;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * 
     */
    public function indexAction()
    {
        $response = new HF\Response();
        $response->setContent('hola');
        $response->send();
       
    }
}
