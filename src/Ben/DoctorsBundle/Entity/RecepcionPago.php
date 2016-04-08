<?php

namespace Ben\DoctorsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * RecepcionPago
 *
 * @ORM\Table(name="recepcion_pago")
 * @ORM\Entity(repositoryClass="Ben\DoctorsBundle\Entity\RecepcionPagoRepository")
 * @Vich\Uploadable
 * 
 */
class RecepcionPago
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
     * @ORM\ManyToOne(targetEntity="Ben\DoctorsBundle\Entity\Proveedor", inversedBy="recepcion_pagos")
     * @ORM\JoinColumn(name="proveedor_id", referencedColumnName="id")
     *   
     */
    protected $proveedor;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_firma", type="date", nullable=true)
     */
    private $fechaFirma;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_recepcion_odc_contrato", type="date", nullable=true)
     */
    private $fechaRecepcionOdcContrato;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_acta", type="date", nullable=true)
     */
    private $fechaActa;

    /**
     * @ORM\ManyToOne(targetEntity="Ben\DoctorsBundle\Entity\Periodo", inversedBy="recepcion_pagos")
     * @ORM\JoinColumn(name="periodo_id", referencedColumnName="id")
     *   
     */
    protected $periodo;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero_acta", type="integer", length=11, nullable=true)
     *
     */
    private $numeroActa;

    /**
     * @ORM\ManyToOne(targetEntity="Ben\DoctorsBundle\Entity\PeriodoMes", inversedBy="recepcion_pagos")
     * @ORM\JoinColumn(name="periodo_mes_id", referencedColumnName="id", nullable=true)
     *   
     */
    protected $periodoMes;

    /**
     * @ORM\ManyToOne(targetEntity="Ben\DoctorsBundle\Entity\Unidad", inversedBy="recepcion_pagos")
     * @ORM\JoinColumn(name="unidad_id", referencedColumnName="id")
     *   
    */
    protected $unidad;

    /**
     * @ORM\ManyToOne(targetEntity="Ben\DoctorsBundle\Entity\LineaTrabajo", inversedBy="recepcion_pagos")
     * @ORM\JoinColumn(name="linea_trabajo_id", referencedColumnName="id")
     *   
    */
    protected $lineaTrabajo;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_factura", type="string", length=255, nullable=true)
     *
     */
    private $numeroFactura;

    /**
     * @var string
     *
     * @ORM\Column(name="valor_factura", type="decimal", precision=10, scale=2, nullable=true, options={"default"= 0.0})
     *
     */
    private $valorFactura;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero_quedan", type="integer", length=11, nullable=true)
     *
     */
    private $numeroQuedan;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_quedan", type="date", nullable=true)
     *
     */
    private $fechaQuedan;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_referencia", type="string", nullable=true)
     *
     */
    private $numeroReferencia;
    
    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="integer", length=1, nullable=true)
     *
     */
    private $estado;
    /*
        1  = tecnico
        2  = neftali
        3  = por aprobar lic trejo
        4  = escanea y adjunta documentación
        5  = se emite nota de envío.
        10 = rechazado
    */
    
    /**
     * @ORM\ManyToOne(targetEntity="Ben\DoctorsBundle\Entity\TipoContratacion", inversedBy="recepcion_pagos")
     * @ORM\JoinColumn(name="tipo_contratacion_id", referencedColumnName="id", nullable=true)
     *   
    */
    protected $tipoContratacion;

    /**
     * @var string
     *
     * @ORM\Column(name="comentarios", type="string", length=255, nullable=true)
     */
    private $comentarios;
    
    /**
     * @ORM\ManyToOne(targetEntity="Ben\DoctorsBundle\Entity\EstaAprobado", inversedBy="recepcion_pagos")
     * @ORM\JoinColumn(name="esta_aprobado_id", referencedColumnName="id")
     *   
     */
    private $estaAprobado;

    /**
     * @ORM\OneToOne(targetEntity="Document", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="doc_id", referencedColumnName="id")
     * @Assert\Type(type="Ben\DoctorsBundle\Entity\Document")
     **/
     
    //private $archivo;
    
    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="recepcion_pago_image", fileNameProperty="imageName", nullable=true)
     * 
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;
    
    /************ constructeur ************/
    
    public function __construct()
    {
        //$this->proveedor = new \Doctrine\Common\Collections\ArrayCollection();
        //$this->unidad = new \Doctrine\Common\Collections\ArrayCollection();
        //$this->lineaTrabajo = new \Doctrine\Common\Collections\ArrayCollection();
        //$this->periodo = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set fechaFirma
     *
     * @param \DateTime $fechaFirma
     * @return RecepcionPago
     */
    public function setFechaFirma($fechaFirma)
    {
        $this->fechaFirma = $fechaFirma;

        return $this;
    }

    /**
     * Get fechaFirma
     *
     * @return \DateTime 
     */
    public function getFechaFirma()
    {
        return $this->fechaFirma;
    }

    /**
     * Set fechaRecepcionOdcContrato
     *
     * @param \DateTime $fechaRecepcionOdcContrato
     * @return RecepcionPago
     */
    public function setFechaRecepcionOdcContrato($fechaRecepcionOdcContrato)
    {
        $this->fechaRecepcionOdcContrato = $fechaRecepcionOdcContrato;

        return $this;
    }

    /**
     * Get fechaRecepcionOdcContrato
     *
     * @return \DateTime 
     */
    public function getFechaRecepcionOdcContrato()
    {
        return $this->fechaRecepcionOdcContrato;
    }

    /**
     * Set fechaActa
     *
     * @param \DateTime $fechaActa
     * @return RecepcionPago
     */
    public function setFechaActa($fechaActa)
    {
        $this->fechaActa = $fechaActa;

        return $this;
    }

    /**
     * Get fechaActa
     *
     * @return \DateTime 
     */
    public function getFechaActa()
    {
        return $this->fechaActa;
    }

    /**
     * Set numeroActa
     *
     * @param integer $numeroActa
     * @return RecepcionPago
     */
    public function setNumeroActa($numeroActa)
    {
        $this->numeroActa = $numeroActa;

        return $this;
    }

    /**
     * Get numeroActa
     *
     * @return integer 
     */
    public function getNumeroActa()
    {
        return $this->numeroActa;
    }

    /**
     * Set numeroFactura
     *
     * @param string $numeroFactura
     * @return RecepcionPago
     */
    public function setNumeroFactura($numeroFactura)
    {
        $this->numeroFactura = $numeroFactura;

        return $this;
    }

    /**
     * Get numeroFactura
     *
     * @return string 
     */
    public function getNumeroFactura()
    {
        return $this->numeroFactura;
    }

    /**
     * Set valorFactura
     *
     * @param string $valorFactura
     * @return RecepcionPago
     */
    public function setValorFactura($valorFactura)
    {
        $this->valorFactura = $valorFactura;

        return $this;
    }

    /**
     * Get valorFactura
     *
     * @return string 
     */
    public function getValorFactura()
    {
        return $this->valorFactura;
    }

    /**
     * Set numeroQuedan
     *
     * @param integer $numeroQuedan
     * @return RecepcionPago
     */
    public function setNumeroQuedan($numeroQuedan)
    {
        $this->numeroQuedan = $numeroQuedan;

        return $this;
    }

    /**
     * Get numeroQuedan
     *
     * @return inteeger 
     */
    public function getNumeroQuedan()
    {
        return $this->numeroQuedan;
    }

    /**
     * Set fechaQuedan
     *
     * @param \DateTime $valorMaximoContrato
     * @return RecepcionPago
     */
    public function setFechaQuedan($fechaQuedan)
    {
        $this->fechaQuedan = $fechaQuedan;

        return $this;
    }

    /**
     * Get fechaQuedan
     *
     * @return \DateTime 
     */
    public function getFechaQuedan()
    {
        return $this->fechaQuedan;
    }

    /**
     * Set numeroReferencia
     *
     * @param string $numeroReferencia
     * @return RecepcionPago
     */
    public function setNumeroReferencia($numeroReferencia)
    {
        $this->numeroReferencia = $numeroReferencia;

        return $this;
    }

    /**
     * Get numeroReferencia
     *
     * @return string 
     */
    public function getNumeroReferencia()
    {
        return $this->numeroReferencia;
    }

    /**
     * Set comentarios
     *
     * @param string $comentarios
     * @return RecepcionPago
     */
    public function setComentarios($comentarios)
    {
        $this->comentarios = $comentarios;

        return $this;
    }

    /**
     * Get comentarios
     *
     * @return string 
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }

    /**
     * Set proveedor
     *
     * @param \Ben\DoctorsBundle\Entity\Proveedor $proveedor
     * @return RecepcionPago
     */
    public function setProveedor(\Ben\DoctorsBundle\Entity\Proveedor $proveedor = null)
    {
        $this->proveedor = $proveedor;

        return $this;
    }

    /**
     * Get proveedor
     *
     * @return \Ben\DoctorsBundle\Entity\Proveedor 
     */
    public function getProveedor()
    {
        return $this->proveedor;
    }
    

    /**
     * Set periodo
     *
     * @param \Ben\DoctorsBundle\Entity\Periodo $periodo
     * @return RecepcionPago
     */
    public function setPeriodo(\Ben\DoctorsBundle\Entity\Periodo $periodo = null)
    {
        $this->periodo = $periodo;

        return $this;
    }

    /**
     * Get periodo
     *
     * @return \Ben\DoctorsBundle\Entity\Periodo 
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * Set periodoMes
     *
     * @param \Ben\DoctorsBundle\Entity\PeriodoMes $periodoMes
     * @return RecepcionPago
     */
    public function setPeriodoMes(\Ben\DoctorsBundle\Entity\PeriodoMes $periodoMes = null)
    {
        $this->periodoMes = $periodoMes;

        return $this;
    }

    /**
     * Get periodoMes
     *
     * @return \Ben\DoctorsBundle\Entity\PeriodoMes 
     */
    public function getPeriodoMes()
    {
        return $this->periodoMes;
    }

    /**
     * Set unidad
     *
     * @param \Ben\DoctorsBundle\Entity\Unidad $unidad
     * @return RecepcionPago
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

    /**
     * Set lineaTrabajo
     *
     * @param \Ben\DoctorsBundle\Entity\LineaTrabajo $lineaTrabajo
     * @return RecepcionPago
     */
    public function setLineaTrabajo(\Ben\DoctorsBundle\Entity\LineaTrabajo $lineaTrabajo = null)
    {
        $this->lineaTrabajo = $lineaTrabajo;

        return $this;
    }

    /**
     * Get lineaTrabajo
     *
     * @return \Ben\DoctorsBundle\Entity\LineaTrabajo 
     */
    public function getLineaTrabajo()
    {
        return $this->lineaTrabajo;
    }

    /**
     * Set tipoContratacion
     *
     * @param \Ben\DoctorsBundle\Entity\TipoContratacion $tipoContratacion
     * @return RecepcionPago
     */
    public function setTipoContratacion(\Ben\DoctorsBundle\Entity\TipoContratacion $tipoContratacion = null)
    {
        $this->tipoContratacion = $tipoContratacion;

        return $this;
    }

    /**
     * Get tipoContratacion
     *
     * @return \Ben\DoctorsBundle\Entity\TipoContratacion 
     */
    public function getTipoContratacion()
    {
        return $this->tipoContratacion;
    }

    /**
     * Set estado
     *
     * @param integer $estado
     * @return RecepcionPago
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
     * Set estaAprobado
     *
     * @param boolean $estaAprobado
     * @return RecepcionPago
     */
    public function setEstaAprobado($estaAprobado)
    {
        $this->estaAprobado = $estaAprobado;

        return $this;
    }

    /**
     * Get estaAprobado
     *
     * @return boolean 
     */
    public function getEstaAprobado()
    {
        return $this->estaAprobado;
    }
    
    /**
     * Set archivo
     *
     * @param \Ben\DoctorsBundle\Entity\Document $archivo
     * @return contratos
     */
    /*public function setArchivo(\Ben\DoctorsBundle\Entity\Document $archivo = null)
    {
        $this->archivo = $archivo;
    
        return $this;
    }*/

    /**
     * Get archivo
     *
     * @return \Ben\DoctorsBundle\Entity\Document
     */
    /*public function getArchivo()
    {
        return $this->archivo;
    }*/
    
    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Product
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image instanceof UploadedFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     *
     * @return Product
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }
}
