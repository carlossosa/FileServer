<?php

namespace BNJM\FilesServerBundle\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * Consultas a la Entidad Store
 *
 * @author Carlos Sosa <carlitin at gmail dot com>
 */
class StoreRepository extends EntityRepository  {
    
    /**
     * Recoge todos los almacenes 
     */
    public function getStores()
    {
        return $this->getEntityManager()
                        ->createQuery("SELECT s FROM FileServerBundle:Store ORDER BY s.name ASC")
                        ->setResultCacheLifetime(30)
                        ->getResult();
    }
}

?>