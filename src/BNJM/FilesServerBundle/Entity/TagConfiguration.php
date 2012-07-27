<?php

namespace BNJM\FilesServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="files_tag_configuration")
 */
class TagConfiguration {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Store")
     * @ORM\JoinColumn(name="store_id", referencedColumnName="id")
     */
    private $store;
    
    /**
     * @ORM\OneToOne(targetEntity="FileTag")
     * @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     */
    private $tag;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $browseable;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $visibility; 

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set browseable
     *
     * @param boolean $browseable
     */
    public function setBrowseable($browseable)
    {
        $this->browseable = $browseable;
    }

    /**
     * Get browseable
     *
     * @return boolean 
     */
    public function getBrowseable()
    {
        return $this->browseable;
    }

    /**
     * Set visibility
     *
     * @param integer $visibility
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    /**
     * Get visibility
     *
     * @return integer 
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Set store
     *
     * @param BNJM\FilesServerBundle\Entity\Store $store
     */
    public function setStore(\BNJM\FilesServerBundle\Entity\Store $store)
    {
        $this->store = $store;
    }

    /**
     * Get store
     *
     * @return BNJM\FilesServerBundle\Entity\Store 
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * Set tag
     *
     * @param BNJM\FilesServerBundle\Entity\FileTag $tag
     */
    public function setTag(\BNJM\FilesServerBundle\Entity\FileTag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * Get tag
     *
     * @return BNJM\FilesServerBundle\Entity\FileTag 
     */
    public function getTag()
    {
        return $this->tag;
    }
}