<?php

namespace BNJM\FilesServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="BNJM\FilesServerBundle\Repository\FileStoreRepository")
 * @ORM\Table(name="files_store",indexes={@ORM\index(name="search_idx", columns={"name", "type"})})
 */
class FileStore {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length="255")
     */    
    private $name;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $size;
    
    /**
     * @ORM\ManyToOne(targetEntity="Store")
     * @ORM\JoinColumn(name="store", referencedColumnName="id")
     */
    private $store;
    
    /**
     * @ORM\Column(type="string", length="120")
     */
    private $type;
    
    /**
     * @ORM\ManyToMany(targetEntity="FileTag", inversedBy="id")
   * @ORM\JoinTable(name="files_tagged",
   *      joinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id")},
   *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
   *      )
     */
    private $tags;    

    
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set size
     *
     * @param integer $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * Get size
     *
     * @return integer 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
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
     * Add tags
     *
     * @param BNJM\FilesServerBundle\Entity\FileTag $tags
     */
    public function addFileTag(\BNJM\FilesServerBundle\Entity\FileTag $tags)
    {
        $this->tags[] = $tags;
    }

    /**
     * Get tags
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }
}