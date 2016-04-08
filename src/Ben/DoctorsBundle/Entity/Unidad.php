<?php

namespace Ben\DoctorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Unidad
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ben\DoctorsBundle\Entity\UnidadRepository")
 */
class Unidad
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
     * @ORM\ManyToOne(targetEntity="Ben\DoctorsBundle\Entity\Periodo", inversedBy="unidades")
     * @ORM\JoinColumn(name="periodo_id", referencedColumnName="id")
     *   
     */
    private $anio;
    
    /**
     * @ORM\ManyToOne(targetEntity="Ben\DoctorsBundle\Entity\Estado", inversedBy="unidades")
     * @ORM\JoinColumn(name="estado_id", referencedColumnName="id")
     *   
     */
    private $estado;
    
    /**
    * @ORM\OneToMany(targetEntity="Ben\DoctorsBundle\Entity\LineaTrabajo", mappedBy="unidad", cascade={"remove", "persist"})
    */
    protected $lineatrabajos;

    /**
     * @ORM\OneToMany(targetEntity="Ben\DoctorsBundle\Entity\RecepcionPago", mappedBy="unidad")
     */
    protected $recepcion_pagos;

    public function __construct()
    {
        $this->recepcion_pagos = new ArrayCollection();
        $this->lineatrabajos = new ArrayCollection();
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
     * @return Unidad
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
     * @return Unidad
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
     * @return Unidad
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
     * @return Unidad
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
     * @return Unidad
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
     * Add lineatrabajos
     *
     * @param \Ben\DoctorsBundle\Entity\LineaTrabajo $lineatrabajos
     * @return LineaTrabajo
     */
    public function addLineatrabajo(\Ben\DoctorsBundle\Entity\LineaTrabajo $lineatrabajos)
    {
        $lineatrabajos->setUnidad($this);
        $this->lineatrabajos->add($lineatrabajos);

        return $this;
    }

    /**
     * Remove lineatrabajos
     *
     * @param \Ben\DoctorsBundle\Entity\LineaTrabajo $lineatrabajos
     */
    public function removeLineatrabajo(\Ben\DoctorsBundle\Entity\LineaTrabajo $lineatrabajos)
    {
        $this->lineatrabajos->removeElement($lineatrabajos);
    }

    /**
     * Get consultationmeds
     *
     * @return \Doctrine\Common\Collections\ArrayCollection 
     */
    public function getLineatrabajos()
    {
        return $this->lineatrabajos;
    }
}
