<?php

namespace Ben\DoctorsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecepcionPagoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('proveedor')
            ->add('fechaFirma', 'date', array(
                    'required' => true,
                    'widget' => 'single_text',
                    'attr' => array(
                        'class'   => 'fecha',
                        //'style' => 'width: 125px;'
                    ),
            ))
            ->add('fechaRecepcionOdcContrato', 'date', array(
                    'required' => true,
                    'widget' => 'single_text',
                    'attr' => array(
                        'class'   => 'fecha',
                        //'style' => 'width: 125px;'
                    ),
            ))
            ->add('fechaActa', 'date', array(
                    'required' => true,
                    'widget' => 'single_text',
                    'attr' => array(
                        'class'   => 'fecha',
                        //'style' => 'width: 125px;'
                    ),
            ))
            ->add('periodo')
            ->add('numeroActa')
            ->add('periodoMes')
            ->add('unidad')
            ->add('lineaTrabajo')
            ->add('numeroFactura')
            ->add('valorFactura')
            ->add('numeroQuedan')
            ->add('fechaQuedan', 'date', array(
                    'required' => true,
                    'widget' => 'single_text',
                    'attr' => array(
                        'class'   => 'fecha',
                        //'style' => 'width: 125px;'
                    ),
            ))
            ->add('numeroReferencia')
            ->add('tipoContratacion')
            ->add('comentarios','textarea')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ben\DoctorsBundle\Entity\RecepcionPago'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ben_recepcion_pago';
    }
}