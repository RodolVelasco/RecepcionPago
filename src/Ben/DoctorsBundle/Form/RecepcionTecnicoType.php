<?php

namespace Ben\DoctorsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Ben\DoctorsBundle\Form\EventListener\AddLineaTrabajoFieldSubscriber;
use Ben\DoctorsBundle\Form\EventListener\AddUnidadFieldSubscriber;

use Ben\DoctorsBundle\Entity\Unidad;
use Ben\DoctorsBundle\Entity\LineaTrabajo;

class RecepcionTecnicoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('proveedor')
            ->add('periodo');

            $builder
                ->addEventSubscriber(new AddLineaTrabajoFieldSubscriber())
                ->addEventSubscriber(new AddUnidadFieldSubscriber())
            ;
            
    $builder->add('valorFactura')
            ->add('numeroReferencia')
            ->add('tipoContratacion')
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
        return 'ben_recepcion_tecnico';
    }
}