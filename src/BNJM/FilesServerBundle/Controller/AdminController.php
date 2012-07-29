<?php

namespace BNJM\FilesServerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Component\HttpFoundation;
use DoctrineExtensions\Paginate\Paginate;
use BNJM\FilesServerBundle\Entity;

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
     * @Route("/_settag", name="FileServer_AjaxSetTag") 
     */
    public function settagAction() {
        $return = array();
        $request = $this->getRequest();
        
        if ( $request->isXmlHttpRequest() )
        {
            if ( $request->get('fileid') )
            {
                $em = $this->getDoctrine()
                                ->getEntityManager();
                $file = $em->getRepository('FileServerBundle:FileStore')
                                ->findOneBy(array('id'=>$request->get('fileid')));
                if ( $file)
                    {
                        if (strlen($request->get('tag'))>2)
                        {
                            $tag = $em->getRepository('FileServerBundle:FileTag')
                                        ->findOneBy(array('tag'=>$request->get('tag')));
                            
                            if ( !$tag) {
                                $tag = new Entity\FileTag();
                                $tag->setTag($request->get('tag'));
                                $file->addFileTag($tag);
                                $em->persist($file);
                                $em->flush();
                            } else {
                                if ( !$file->getTags()->contains($tag))
                                {
                                    $file->addFileTag($tag);
                                    $em->persist($file);
                                    $em->flush();
                                }
                            }
                            
                            
                            
                            return new HttpFoundation\Response(json_encode(array('err'=>'OK')));
                            
                        } else return new HttpFoundation\Response(json_encode(array('err'=>'Etiqueta demasiado corta.')));
                    }
                    else return new HttpFoundation\Response('Archivo desconosido.', 404);
            } else return new HttpFoundation\Response('Archivo desconosido.', 404);
        } else return new HttpFoundation\Response('Ninguna acción disponibles', 404);
        
    }
    
    /**
     * @Route("/_unsettag", name="FileServer_AjaxUnSetTag") 
     */
    public function unsettagAction() {
        $return = array();
        $request = $this->getRequest();
        $field = explode("_", $request->get('field'));
        
        if ( $request->isXmlHttpRequest() )
        {
            if ( $field[2] )
            {
                $em = $this->getDoctrine()
                                ->getEntityManager();
                $file = $em->getRepository('FileServerBundle:FileStore')
                                ->findOneBy(array('id'=>$field[2]));
                if ( $file)
                    {
                            $tag = $em->getRepository('FileServerBundle:FileTag')
                                        ->findOneBy(array('tag'=>$field[1]));
                            
                            if ( $tag) {
                                if ( $file->getTags()->contains($tag) )
                                {
                                    $file->getTags()->removeElement($tag);
                                    $em->persist($file);
                                    $em->flush();                                            
                                    return new HttpFoundation\Response(json_encode(array('err'=>'OK')));                                                    
                                } else return new HttpFoundation\Response(json_encode(array('err'=>'OK')));                                                    
                            } return new HttpFoundation\Response(json_encode(array('err'=>'Etiqueta no válida.')));                                                    
                    }
                    else return new HttpFoundation\Response('Archivo desconosido.', 404);
            } else return new HttpFoundation\Response('Archivo desconosido.', 404);
        } else return new HttpFoundation\Response('Ninguna acción disponibles', 404);
        
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
