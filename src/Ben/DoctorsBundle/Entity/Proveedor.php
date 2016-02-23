<?php

namespace Ben\DoctorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proveedor
 *
 * @ORM\Table(name="proveedor", options={"collate"="utf8_general_ci"})
 * @ORM\Entity(repositoryClass="Ben\DoctorsBundle\Entity\ProveedorRepository")
 */
class Proveedor
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
     * @ORM\Column(name="codigo", type="string", length=255, nullable=true)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="razon_social", type="string", length=255, nullable=true)
     */
    private $razonSocial;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_comercial", type="string", length=255, nullable=true)
     */
    private $nombreComercial;

    /**
     * @var string
     *
     * @ORM\Column(name="area", type="string", length=2000, nullable=true)
     */
    private $area;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255, nullable=true)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="nit", type="string", length=255, nullable=true)
     */
    private $nit;

    /**
     * @var string
     *
     * @ORM\Column(name="nrc", type="string", length=255, nullable=true)
     */
    private $nrc;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=255, nullable=true)
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=255, nullable=true)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="contacto", type="string", length=2000, nullable=true)
     */
    private $contacto;

    /**
     * @var string
     *
     * @ORM\Column(name="contacto_cargo", type="string", length=500, nullable=true)
     */
    private $contactoCargo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;


    /**
     * @ORM\OneToMany(targetEntity="Ben\DoctorsBundle\Entity\RecepcionPago", mappedBy="proveedor")
     */
    protected $recepcion_pagos;

    public function __construct()
    {
        $this->recepcion_pagos = new \Doctrine\Common\Collections\ArrayCollection();

    }

    public function __toString()
    {
        return $this->getCodigo().' - '.$this->getRazonSocial();
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
     * Set codigo
     *
     * @param string $codigo
     * @return Proveedor
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
     * Set razonSocial
     *
     * @param string $razonSocial
     * @return Proveedor
     */
    public function setRazonSocial($razonSocial)
    {
        $this->razonSocial = $razonSocial;

        return $this;
    }

    /**
     * Get razonSocial
     *
     * @return string 
     */
    public function getRazonSocial()
    {
        return $this->razonSocial;
    }

    /**
     * Set nombreComercial
     *
     * @param string $nombreComercial
     * @return Proveedor
     */
    public function setNombreComercial($nombreComercial)
    {
        $this->nombreComercial = $nombreComercial;

        return $this;
    }

    /**
     * Get nombreComercial
     *
     * @return string 
     */
    public function getNombreComercial()
    {
        return $this->nombreComercial;
    }

    /**
     * Set area
     *
     * @param string $area
     * @return Proveedor
     */
    public function setArea($area)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return string 
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Proveedor
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set nit
     *
     * @param string $nit
     * @return Proveedor
     */
    public function setNit($nit)
    {
        $this->nit = $nit;

        return $this;
    }

    /**
     * Get nit
     *
     * @return string 
     */
    public function getNit()
    {
        return $this->nit;
    }

    /**
     * Set nrc
     *
     * @param string $nrc
     * @return Proveedor
     */
    public function setNrc($nrc)
    {
        $this->nrc = $nrc;

        return $this;
    }

    /**
     * Get nrc
     *
     * @return string 
     */
    public function getNrc()
    {
        return $this->nrc;
    }

    /**
     * Set tel
     *
     * @param string $tel
     * @return Proveedor
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string 
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return Proveedor
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set contacto
     *
     * @param string $contacto
     * @return Proveedor
     */
    public function setContacto($contacto)
    {
        $this->contacto = $contacto;

        return $this;
    }

    /**
     * Get contacto
     *
     * @return string 
     */
    public function getContacto()
    {
        return $this->contacto;
    }

    /**
     * Set contactoCargo
     *
     * @param string $contactoCargo
     * @return Proveedor
     */
    public function setContactoCargo($contactoCargo)
    {
        $this->contactoCargo = $contactoCargo;

        return $this;
    }

    /**
     * Get contactoCargo
     *
     * @return string 
     */
    public function getContactoCargo()
    {
        return $this->contactoCargo;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Proveedor
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Add recepcion_pagos
     *
     * @param \Ben\DoctorsBundle\Entity\RecepcionPago $recepcionPagos
     * @return Proveedor
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
