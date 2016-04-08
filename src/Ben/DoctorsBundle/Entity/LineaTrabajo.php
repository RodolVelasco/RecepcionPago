<?php

namespace Ben\DoctorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * LineaTrabajo
 *
 * @ORM\Table(name="lineatrabajo", options={"collate"="utf8_general_ci"})
 * @ORM\Entity(repositoryClass="Ben\DoctorsBundle\Entity\LineaTrabajoRepository")
 */
class LineaTrabajo
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=255)
     */
    private $codigo;
    
    /**
     * @ORM\ManyToOne(targetEntity="Ben\DoctorsBundle\Entity\Periodo", inversedBy="lineatrabajos")
     * @ORM\JoinColumn(name="periodo_id", referencedColumnName="id")
     *   
     */
    private $anio;
    
    /**
     * @ORM\ManyToOne(targetEntity="Ben\DoctorsBundle\Entity\Estado", inversedBy="lineatrabajos")
     * @ORM\JoinColumn(name="estado_id", referencedColumnName="id")
     *   
     */
    private $estado;
    
    /**
    * @ORM\ManyToOne(targetEntity="Ben\DoctorsBundle\Entity\Unidad", inversedBy="lineatrabajos")
    * @ORM\JoinColumn(name="unidad_id", referencedColumnName="id", nullable=true)
    */
    protected $unidad;

    /**
     * @ORM\OneToMany(targetEntity="Ben\DoctorsBundle\Entity\RecepcionPago", mappedBy="lineaTrabajo")
     */
    protected $recepcion_pagos;

    public function __construct()
    {
        $this->recepcion_pagos = new ArrayCollection();
        //$this->unidad = new ArrayCollection();
        
    }

    public function __toString()
    {
        return $this->getCodigo().' - '.$this->getNombre();
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
     * Set nombre
     *
     * @param string $nombre
     * @return LineaTrabajo
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

    /**
     * Add recepcion_pagos
     *
     * @param \Ben\DoctorsBundle\Entity\RecepcionPago $recepcionPagos
     * @return LineaTrabajo
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
     * Set codigo
     *
     * @param string $codigo
     * @return LineaTrabajo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set anio
     *
     * @param integer $anio
     * @return LineaTrabajo
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Get anio
     *
     * @return integer 
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Set estado
     *
     * @param integer $estado
     * @return LineaTrabajo
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return integer 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set unidad
     *
     * @param \Ben\DoctorsBundle\Entity\Unidad $unidad
     * @return LineaTrabajo
     */
    public function setUnidad(\Ben\DoctorsBundle\Entity\Unidad $unidad = null)
    {
        $this->unidad = $unidad;

        return $this;
    }

    /**
     * Get unidad
     *
     * @return \Ben\DoctorsBundle\Entity\Unidad 
     */
    public function getUnidad()
    {
        return $this->unidad;
    }
}
