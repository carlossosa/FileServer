<?php

namespace BNJM\FilesServerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controlador para la Subida de Archivos
 *
 * @author CarlosyLea
 */
class FileUploadController extends Controller {

    /**
     * @Route("/{store}/_upload") 
     */
    public function indexAction($store) {
        return array();
    }

}

?>