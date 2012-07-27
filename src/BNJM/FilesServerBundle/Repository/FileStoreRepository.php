<?php

namespace BNJM\FilesServerBundle\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * @author Carlos Sosa <carlitin at gmail dot com>
 */
class FileStoreRepository extends EntityRepository 
    {
    public function findFilesByTagAndStore( $tag, $store) 
        {
            $em = $this->getEntityManager();
            $dql = "SELECT f FROM FileServerBundle:FileStore f". 
                   " JOIN f.store s ";            
            
            if ( $tag != NULL)
            {
                $dql .= "JOIN f.tags t".
                        " WHERE s.name = :store AND t.tag = :tag";
                $q = $em->createQuery($dql)
                        ->setParameter("store", $store)                
                        ->setParameter("tag", $tag);
            } else {     
                $dql .= " WHERE s.name = :store";
                $q = $em->createQuery($dql)
                        ->setParameter("store", $store);
            }
            
            return $q->getResult();
        }      
    }

?>