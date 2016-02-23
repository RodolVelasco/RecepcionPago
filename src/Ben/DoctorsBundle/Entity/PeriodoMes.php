<?php

namespace Ben\DoctorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Periodo_mes
 *
 * @ORM\Table(name="periodomes", options={"collate"="utf8_general_ci"})
 * @ORM\Entity(repositoryClass="Ben\DoctorsBundle\Entity\PeriodoMesRepository")
 */
class PeriodoMes
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
     * @ORM\OneToMany(targetEntity="Ben\DoctorsBundle\Entity\RecepcionPago", mappedBy="periodoMes")
     */
    protected $recepcion_pagos;

    public function __construct()
    {
        $this->recepcion_pagos = new ArrayCollection();

    }

    public function __toString()
    {
        return $this->getNombre();
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
     * Set nombre_mes
     *
     * @param string $nombre
     * @return PeriodoMes
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre_mes
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
     * @return PeriodoMes
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
}
