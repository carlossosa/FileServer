<?php

namespace BNJM\FilesServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ip_location")
 */
class IPLocation {

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
     * @ORM\Column(type="array", nullable=true)
     */
    private $rango;    

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
     * Set rango
     *
     * @param array $rango
     */
    public function setRango($rango)
    {
        $this->rango = $rango;
    }

    /**
     * Get rango
     *
     * @return array 
     */
    public function getRango()
    {
        return $this->rango;
    }
}