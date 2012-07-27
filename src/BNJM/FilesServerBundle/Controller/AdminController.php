<?php

namespace BNJM\FilesServerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation as HF;

class AdminController extends Controller
{
    /**
     * @Route("/", name="FileServer_ListadoAlmacenes")
     * @Template("FileServerBundle:Admin:almacenes.html.twig");
     */
    public function indexAction() {
        $store = $this->getDoctrine()->
                        getEntityManager()->
                        getRepository('FileServerBundle:Store')->
                        findAll();
        return array("stores"=>$store);
    }
    
    /**
     * @Route("/{almacen}", name="FileServer_ListadoArchivos")
     * @Template()
     */
    public function filesAction( $almacen) {
        $store = $this->getDoctrine()->
                        getEntityManager()->
                        getRepository('FileServerBundle:Store')->
                        findOneBy(array('name'=>$almacen));
        return array("store"=>$store);
    }
}
