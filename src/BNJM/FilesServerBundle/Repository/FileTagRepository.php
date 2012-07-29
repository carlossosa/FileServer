<?php

namespace BNJM\FilesServerBundle\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * @author Carlos Sosa <carlitin at gmail dot com>
 */
class FileTagRepository extends EntityRepository 
    {
        public function searchTags ( $s)
        {
            $search = $this->getEntityManager()
                           ->createQuery("SELECT t.tag FROM FileServerBundle:FileTag t ".
                                         "WHERE t.tag LIKE :search")
                           ->setMaxResults(4)
                           ->setParameter('search', '%'.$s.'%')
                           ->getArrayResult();
            return $search;
        }
    }        
    
    

?>