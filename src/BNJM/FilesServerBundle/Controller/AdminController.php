<?php

namespace BNJM\FilesServerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Component\HttpFoundation;
use DoctrineExtensions\Paginate\Paginate;

class AdminController extends Controller
{
    /**
     * @Route("/", name="FileServer_ListadoAlmacenes")
     * @Template("FileServerBundle:Admin:almacenes.html.twig")
     * @Cache(expires="+30 seconds",maxage=60)
     */
    public function indexAction() {
        $store = $this->getDoctrine()->
                        getEntityManager()->                        
                        getRepository('FileServerBundle:Store')->
                        findAll();
        return array("stores"=>$store);
    }
    
    /**
     * @Route("/_tags", name="FileServer_AjaxListadoTags") 
     * @Cache(expires="now",maxage=0,smaxage=0)
     */
    public function listadotagsAction ()
    {
        $tags = $this->getDoctrine()
                        ->getEntityManager()
                        ->getRepository('FileServerBundle:FileTag')
                        ->searchTags( $this->getRequest()->get('term'));
        $_tags = array();
        foreach ( $tags as $t) $_tags[] = $t['tag'];        
        return new HttpFoundation\Response( json_encode( $_tags ) );
    }
    
    /**
     * @Route("/{almacen}/{tag}", name="FileServer_ListadoArchivos", defaults={"tag" = "none"})
     * @Template()
     */
    public function filesAction( $almacen, $tag) {
        if ( $tag == "none") $tag = NULL;
        
        $pagina = $this->getRequest()->get( 'page', 1);
        if ( $pagina > 1) $pagina_p = $pagina-1;
        else $pagina_p = false;
        
        if ( $this->getRequest()->get( 'show') )
        {
            $this->getRequest()->getSession()->set($almacen.'_pager_perpage', $this->getRequest()->get( 'show'));
        }
        
        $perpage = $this->getRequest()->getSession()->get($almacen.'_pager_perpage', 10);
        $offset = ($pagina-1) * $perpage;
        
        $q = $this->getDoctrine()
                        ->getEntityManager()
                        ->getRepository('FileServerBundle:FileStore')
                        ->queryFilesByTagAndStore( $tag, $almacen);   
        $totalFiles = Paginate::getTotalQueryResults($q);
        
        if ( $offset >= $totalFiles) $offset = 0;
        
        if ( $totalFiles > 0)
            $paginate = Paginate::getPaginateQuery($q, $offset, 1 * $perpage)->getResult();
        else $paginate = false;
        
        if ( intval($totalFiles/$perpage)+1 > $pagina ) $pagina_n = $pagina+1;
        else $pagina_n = false;
        
        return array("files"=>$paginate, 
                        "tags"=>$tag, 
                        "almacen" => $almacen, 
                        "porpagina"=>$perpage, 
                        "paginas"=>intval($totalFiles/$perpage)+1,
                        "pagina"=>$pagina,
                        "paginaprev"=>$pagina_p,
                        "paginanext"=>$pagina_n);
    }        
}
