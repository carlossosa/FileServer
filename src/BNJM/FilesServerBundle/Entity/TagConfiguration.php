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
     * @ORM\ManyToMany(targetEntity="IPLocation", inversedBy="id")
     * @ORM\JoinTable(name="files_tags_configuration_ip",
     *      joinColumns={@ORM\JoinColumn(name="tagconfig_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="iplocation_ip", referencedColumnName="id")}
     *      )
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
    public function __construct()
    {
        $this->visibility = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add visibility
     *
     * @param BNJM\FilesServerBundle\Entity\IPLocation $visibility
     */
    public function addIPLocation(\BNJM\FilesServerBundle\Entity\IPLocation $visibility)
    {
        $this->visibility[] = $visibility;
    }

    /**
     * Get visibility
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getVisibility()
    {
        return $this->visibility;
    }
}