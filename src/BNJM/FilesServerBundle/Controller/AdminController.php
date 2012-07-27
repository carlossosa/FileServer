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
     * @Route("/{almacen}/{tag}", name="FileServer_ListadoArchivos", defaults={"tag" = "none"})
     * @Template()
     */
    public function filesAction( $almacen, $tag) {
        if ( $tag == "none") $tag = NULL;
        
        $files = $this->getDoctrine()
                        ->getEntityManager()
                        ->getRepository('FileServerBundle:FileStore')
                        ->findFilesByTagAndStore( $tag, $almacen);        
        
        return array("files"=>$files, "tags"=>$tag, "almacen" => $almacen);
    }
}
