<?php

namespace BNJM\FilesServerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Component\HttpFoundation;


/**
 * @author Carlos Sosa <carlitin at gmail dot com>
 */
class FileDownloadController extends Controller {

    /**
     * @Route("/{store}/{tag}/{filename}")
     * 
     * @return \Symfony\Component\HttpFoundation\Response 
     */
    public function fileAction($store,$tag,$filename) {
        $file = $this->getDoctrine()
                        ->getEntityManager()
                        ->getRepository('FileServerBundle:FileStore')
                        ->getFileByTagAndStore($tag,$store,$filename);
                
        if ( $file == null)
        {
            $response = new Response( 'El archivo no existe.', 404);
        } else {
            $response = new Response( 'El archivo no se encuentra disponible', 404);
        }
        
        return $response;
    }

}

?>