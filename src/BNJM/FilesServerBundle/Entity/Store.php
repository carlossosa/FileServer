<?php

namespace BNJM\FilesServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="Stores", uniqueConstraints={@ORM\UniqueConstraint(name="idx_name",columns={"name"})})
 */
class Store {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length="150")
     */
    private $name;
    
    /**
     * @ORM\Column(type="string", length="255")
     */
    private $descripcion;
    
    /**
     * @ORM\OneToMany(targetEntity="FileStore", mappedBy="store")
     */
    private $files;
    
    public function __construct()
    {
        $this->files = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add files
     *
     * @param BNJM\FilesServerBundle\Entity\FileStore $files
     */
    public function addFileStore(\BNJM\FilesServerBundle\Entity\FileStore $files)
    {
        $this->files[] = $files;
    }

    /**
     * Get files
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getFiles()
    {
        return $this->files;
    }
    
    /**
     * @return integer 
     */
    public function getSize() {
        $size = 0;
        foreach( $this->files as $file)
            $size += $file->getSize();
        return $size;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
}