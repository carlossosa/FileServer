<?php

namespace BNJM\FilesServerBundle\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * @author Carlos Sosa <carlitin at gmail dot com>
 */
class FileStoreRepository extends EntityRepository 
    {
    public function queryFilesByTagAndStore( $tag, $store, $cache=true, $sort='name') 
        {
            $em = $this->getEntityManager();
            $dql = "SELECT f FROM FileServerBundle:FileStore f". 
                   " JOIN f.store s ";            
            
            if ( $tag != NULL)
            {
                $dql .= "JOIN f.tags t".
                        " WHERE s.name = :store AND t.tag = :tag";                
            } else {     
                $dql .= " WHERE s.name = :store";                
            }                        

            $dql .= " ORDER BY f.".$sort." ASC";
            
            $q = $em->createQuery($dql)
                        ->setParameter("store", $store);
            
            if ( $tag != NULL)
                $q->setParameter("tag", $tag);
            
            if ( $cache)
                $q->setResultCacheLifetime(3600);
            else $q->expireResultCache ();
            
            return $q;                           
        }
        
    public function getFileByTagAndStore( $tag, $store, $filename) {
        return $this->getEntityManager()
                        ->createQuery("SELECT t, s, f FROM FileServerBundle:FileStore f ".
                                        "JOIN f.tags t JOIN f.store s ".
                                        "WHERE s.name = :store ".
                                        "AND t.tag = :tag ".
                                        "AND f.name = :filename ")
                        ->setParameters(array(  "tag" => $tag,
                                                "store" => $store,
                                                "filename" => $filename))
                        ->getOneOrNullResult();
    }
    }        
    
    

?>