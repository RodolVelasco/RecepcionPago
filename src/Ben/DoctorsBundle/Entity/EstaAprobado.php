<?php

namespace Ben\DoctorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EstaAprobado
 *
 * @ORM\Table(name="esta_aprobado", options={"collate"="utf8_general_ci"})
 * @ORM\Entity(repositoryClass="Ben\DoctorsBundle\Entity\EstaAprobadoRepository")
 */
class EstaAprobado
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=false)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="Ben\DoctorsBundle\Entity\RecepcionPago", mappedBy="estaAprobado")
     */
    protected $recepcion_pagos;

    public function __construct()
    {
        $this->recepcion_pagos = new \Doctrine\Common\Collections\ArrayCollection();

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
    
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
    }

    /**
     * Add recepcion_pagos
     *
     * @param \Ben\DoctorsBundle\Entity\RecepcionPago $recepcionPagos
     * @return EstaAprobado
     */
    public function addRecepcionPago(\Ben\DoctorsBundle\Entity\RecepcionPago $recepcionPagos)
    {
        $this->recepcion_pagos[] = $recepcionPagos;

        return $this;
    }

    /**
     * Remove recepcion_pagos
     *
     * @param \Ben\DoctorsBundle\Entity\RecepcionPago $recepcionPagos
     */
    public function removeRecepcionPago(\Ben\DoctorsBundle\Entity\RecepcionPago $recepcionPagos)
    {
        $this->recepcion_pagos->removeElement($recepcionPagos);
    }

    /**
     * Get recepcion_pagos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecepcionPagos()
    {
        return $this->recepcion_pagos;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return EstaAprobado
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }
    
    public function __toString()
    {
         return (string) $this->getNombre();
    }
}
