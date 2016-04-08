<?php

namespace Ben\DoctorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Periodo
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ben\DoctorsBundle\Entity\PeriodoRepository")
 */
class Periodo
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
    private $periodo;

    /**
     * @ORM\OneToMany(targetEntity="Ben\DoctorsBundle\Entity\RecepcionPago", mappedBy="periodo")
     */
    protected $recepcion_pagos;

    /**
     * @ORM\OneToMany(targetEntity="Ben\DoctorsBundle\Entity\Unidad", mappedBy="anio")
     */
    protected $unidades;
    
    /**
     * @ORM\OneToMany(targetEntity="Ben\DoctorsBundle\Entity\LineaTrabajo", mappedBy="anio")
     */
    protected $lineatrabajos;

    public function __construct()
    {
        $this->recepcion_pagos = new ArrayCollection();
        $this->unidades = new ArrayCollection();
        $this->lineatrabajos = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getPeriodo();
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
     * Set periodo
     *
     * @param string $periodo
     * @return Periodo
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;

        return $this;
    }

    /**
     * Get periodo
     *
     * @return string 
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * Add recepcion_pagos
     *
     * @param \Ben\DoctorsBundle\Entity\RecepcionPago $recepcionPagos
     * @return Periodo
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
     * Add unidades
     *
     * @param \Ben\DoctorsBundle\Entity\Unidad $unidades
     * @return Periodo
     */
    public function addUnidade(\Ben\DoctorsBundle\Entity\Unidad $unidades)
    {
        $this->unidades[] = $unidades;

        return $this;
    }

    /**
     * Remove unidades
     *
     * @param \Ben\DoctorsBundle\Entity\Unidad $unidades
     */
    public function removeUnidade(\Ben\DoctorsBundle\Entity\Unidad $unidades)
    {
        $this->unidades->removeElement($unidades);
    }

    /**
     * Get unidades
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUnidades()
    {
        return $this->unidades;
    }

    /**
     * Add lineatrabajos
     *
     * @param \Ben\DoctorsBundle\Entity\LineaTrabajo $lineatrabajos
     * @return Periodo
     */
    public function addLineatrabajo(\Ben\DoctorsBundle\Entity\LineaTrabajo $lineatrabajos)
    {
        $this->lineatrabajos[] = $lineatrabajos;

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
     * Get lineatrabajos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLineatrabajos()
    {
        return $this->lineatrabajos;
    }
}
